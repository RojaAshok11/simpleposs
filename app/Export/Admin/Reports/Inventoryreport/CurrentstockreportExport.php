<?php

namespace App\Export\Admin\Reports\Inventoryreport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CurrentstockreportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    private $currentstock;

    public function __construct($currentstock)
    {
        $this->currentstock = $currentstock;
    }

    public function collection()
    {
        return $this->currentstock;
    }

    public function map($currentstock): array
    {
        return [

            $currentstock->uniqid,
            $currentstock->name ? $currentstock->name : '',
            $currentstock->sku ? $currentstock->sku : '-',
            $currentstock->stock ? $currentstock->stock : '0',

        ];
    }

    public function headings(): array
    {
        return [['CURRENT STOCK REPORT'], [], [
            'PRODUCT ID',
            'PRODUCT NAME',
            'SKU',
            'CURRENT STOCK',
        ],
        ];
    }

}
