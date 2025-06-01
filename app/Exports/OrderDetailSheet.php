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

class OrderDetailSheet implements
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
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function collection()
    {
        return $this->order->items;
    }

    public function title(): string
    {
        return 'Заказ #' . $this->order->id;
    }

    public function startCell(): string
    {
        return 'A12';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Товар',
            'Цена',
            'Количество',
            'Сумма'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->product ? $item->product->name : 'Товар недоступен',
            $item->price,
            $item->quantity,
            $item->price * $item->quantity
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            12 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1B5E20']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
            'A' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Заголовок
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'ДЕТАЛИ ЗАКАЗА #' . $this->order->id);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Информация о заказе
                $sheet->setCellValue('A3', 'Дата заказа:');
                $sheet->setCellValue('B3', Carbon::parse($this->order->created_at)->format('d.m.Y H:i'));

                $sheet->setCellValue('A4', 'Статус:');
                $sheet->setCellValue('B4', $this->order->status == 'completed' ? 'Выполнен' : 'В обработке');

                $sheet->setCellValue('A5', 'Способ оплаты:');
                $sheet->setCellValue('B5', $this->order->payment_method == 'card' ? 'Банковская карта' : 'Наличные');

                // Информация о клиенте
                $sheet->mergeCells('A7:E7');
                $sheet->setCellValue('A7', 'ИНФОРМАЦИЯ О КЛИЕНТЕ');
                $sheet->getStyle('A7')->getFont()->setBold(true);
                $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('A8', 'Имя:');
                $sheet->setCellValue('B8', $this->order->user ? $this->order->user->name : 'Удаленный пользователь');

                $sheet->setCellValue('A9', 'Email:');
                $sheet->setCellValue('B9', $this->order->user ? $this->order->user->email : '');

                $sheet->setCellValue('A10', 'Телефон:');
                $sheet->setCellValue('B10', $this->order->user ? $this->order->user->phone : '');

                // Границы для данных
                $lastRow = $sheet->getHighestRow();
                $range = 'A12:E' . $lastRow;
                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Итоговая строка
                $totalRow = $lastRow + 1;
                $sheet->setCellValue('A' . $totalRow, 'ИТОГО:');
                $sheet->mergeCells('A' . $totalRow . ':D' . $totalRow);
                $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // Вычисляем сумму в PHP вместо формулы Excel
                $totalSum = $this->order->items->sum(function($item) {
                    return $item->price * $item->quantity;
                });
                $sheet->setCellValue('E' . $totalRow, $totalSum);
                $sheet->getStyle('E' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('E' . $totalRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                // Стиль итоговой строки
                $sheet->getStyle('A' . $totalRow . ':E' . $totalRow)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E8F5E9');

                // Адрес доставки
                $addressRow = $totalRow + 2;
                $sheet->mergeCells('A' . $addressRow . ':E' . $addressRow);
                $sheet->setCellValue('A' . $addressRow, 'АДРЕС ДОСТАВКИ');
                $sheet->getStyle('A' . $addressRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $addressRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $addressRow++;
                if ($this->order->deliveryAddress) {
                    $sheet->setCellValue('A' . $addressRow, 'Город:');
                    $sheet->setCellValue('B' . $addressRow, $this->order->deliveryAddress->city);

                    $addressRow++;
                    $sheet->setCellValue('A' . $addressRow, 'Улица:');
                    $sheet->setCellValue('B' . $addressRow, $this->order->deliveryAddress->street);

                    $addressRow++;
                    $sheet->setCellValue('A' . $addressRow, 'Индекс:');
                    $sheet->setCellValue('B' . $addressRow, $this->order->deliveryAddress->postal_code);
                } else {
                    $sheet->mergeCells('A' . $addressRow . ':E' . $addressRow);
                    $sheet->setCellValue('A' . $addressRow, 'Адрес доставки не указан');
                    $sheet->getStyle('A' . $addressRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                // Стили для информационных ячеек
                $sheet->getStyle('A3:A10')->getFont()->setBold(true);
                $sheet->getStyle('A' . ($totalRow + 3) . ':A' . $addressRow)->getFont()->setBold(true);
            },
        ];
    }
}