<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Carbon\Carbon;

class OrdersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithColumnFormatting,
    WithEvents,
    WithCustomStartCell
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->orders) {
            return $this->orders;
        }

        $query = Order::with(['user', 'deliveryAddress', 'items.product']);

        // Применяем фильтры, если они заданы
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->latest()->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Отчет по заказам';
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A5';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '№ заказа',
            'Дата',
            'Клиент',
            'Email',
            'Телефон',
            'Адрес доставки',
            'Способ оплаты',
            'Статус',
            'Кол-во товаров',
            'Сумма'
        ];
    }

    /**
     * @param mixed $order
     * @return array
     */
    public function map($order): array
    {
        $address = $order->deliveryAddress ?
            "{$order->deliveryAddress->city}, {$order->deliveryAddress->street}, {$order->deliveryAddress->postal_code}" :
            'Не указан';

        $paymentMethod = $order->payment_method == 'card' ? 'Банковская карта' : 'Наличные';

        $status = $order->status == 'completed' ? 'Выполнен' : 'В обработке';

        return [
            $order->id,
            Carbon::parse($order->created_at)->format('d.m.Y H:i'),
            $order->user ? $order->user->name : 'Удаленный пользователь',
            $order->user ? $order->user->email : '',
            $order->user ? $order->user->phone : '',
            $address,
            $paymentMethod,
            $status,
            $order->items->sum('quantity'),
            $order->total_amount
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Стиль для заголовков
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B5E20'] // Темно-зеленый цвет
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
            // Стиль для всех ячеек
            'A' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'G' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'H' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'I' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'J' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Добавляем заголовок отчета
                $sheet->mergeCells('A1:J1');
                $sheet->setCellValue('A1', 'ОТЧЕТ ПО ЗАКАЗАМ');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Добавляем информацию о периоде
                $sheet->mergeCells('A2:J2');
                $periodText = 'Период: ';
                if ($this->dateFrom && $this->dateTo) {
                    $periodText .= 'с ' . Carbon::parse($this->dateFrom)->format('d.m.Y') . ' по ' . Carbon::parse($this->dateTo)->format('d.m.Y');
                } elseif ($this->dateFrom) {
                    $periodText .= 'с ' . Carbon::parse($this->dateFrom)->format('d.m.Y');
                } elseif ($this->dateTo) {
                    $periodText .= 'по ' . Carbon::parse($this->dateTo)->format('d.m.Y');
                } else {
                    $periodText .= 'все время';
                }
                $sheet->setCellValue('A2', $periodText);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Добавляем информацию о статусе
                $sheet->mergeCells('A3:J3');
                $statusText = 'Статус: ';
                if ($this->status == 'completed') {
                    $statusText .= 'Выполнен';
                } elseif ($this->status == 'pending') {
                    $statusText .= 'В обработке';
                } else {
                    $statusText .= 'Все';
                }
                $sheet->setCellValue('A3', $statusText);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Добавляем дату формирования отчета
                $sheet->mergeCells('A4:J4');
                $sheet->setCellValue('A4', 'Дата формирования: ' . Carbon::now()->format('d.m.Y H:i'));
                $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Устанавливаем границы для всех ячеек с данными
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                $range = 'A5:' . $lastColumn . $lastRow;
                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Добавляем итоговую строку
                $totalRow = $lastRow + 1;
                $sheet->setCellValue('A' . $totalRow, 'ИТОГО:');
                $sheet->mergeCells('A' . $totalRow . ':H' . $totalRow);
                $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Суммируем количество товаров
                $sheet->setCellValue('I' . $totalRow, '=SUM(I6:I' . $lastRow . ')');
                $sheet->getStyle('I' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('I' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Суммируем общую сумму
                $sheet->setCellValue('J' . $totalRow, '=SUM(J6:J' . $lastRow . ')');
                $sheet->getStyle('J' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('J' . $totalRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('J' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Выделяем итоговую строку
                $sheet->getStyle('A' . $totalRow . ':J' . $totalRow)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E8F5E9'); // Светло-зеленый цвет

                // Устанавливаем автофильтр для заголовков
                $sheet->setAutoFilter('A5:' . $lastColumn . '5');

                // Замораживаем верхнюю строку с заголовками
                $sheet->freezePane('A6');

                // Устанавливаем условное форматирование для статусов
                $conditionalStyles = [
                    new \PhpOffice\PhpSpreadsheet\Style\Conditional(),
                    new \PhpOffice\PhpSpreadsheet\Style\Conditional(),
                ];

                $conditionalStyles[0]->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT)
                    ->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT)
                    ->setText('Выполнен');
                $conditionalStyles[0]->getStyle()->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E8F5E9'); // Светло-зеленый для выполненных

                $conditionalStyles[1]->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT)
                    ->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT)
                    ->setText('В обработке');
                $conditionalStyles[1]->getStyle()->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFF8E1'); // Светло-желтый для в обработке

                $conditionalRange = 'H6:H' . $lastRow;
                $sheet->getStyle($conditionalRange)->setConditionalStyles($conditionalStyles);

                // Устанавливаем ширину столбцов
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(40);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(15);
                $sheet->getColumnDimension('J')->setWidth(15);
            },
        ];
    }
}
