<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use App\Exports\OrderDetailSheet;
use App\Exports\OrdersExport;

class OrdersDetailExport implements WithMultipleSheets
{
    protected $orders;
    protected $dateFrom;
    protected $dateTo;
    protected $status;

    public function __construct($orders = null, $dateFrom = null, $dateTo = null, $status = null)
    {
        $this->orders = $orders;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Добавляем основной лист с общей информацией
        $sheets[] = new OrdersExport($this->orders, $this->dateFrom, $this->dateTo, $this->status);

        // Получаем заказы, если они не были переданы
        if (!$this->orders) {
            $query = Order::with(['user', 'deliveryAddress', 'items.product']);

            if ($this->dateFrom) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            }

            if ($this->dateTo) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            }

            if ($this->status) {
                $query->where('status', $this->status);
            }

            $this->orders = $query->latest()->get();
        }

        // Добавляем отдельный лист для каждого заказа
        foreach ($this->orders as $order) {
            $sheets[] = new OrderDetailSheet($order);
        }

        return $sheets;
    }
}
