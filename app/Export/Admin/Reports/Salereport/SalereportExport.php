<?php

namespace App\Export\Admin\Reports\Salereport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalereportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    private $salereport;

    public function __construct($salereport)
    {
        $this->salereport = $salereport;
    }

    public function collection()
    {
        return $this->salereport;
    }

    public function map($salereport): array
    {
        return [
            $salereport->uniqid,
            $salereport->customer?->name,
            $salereport->mode ? config('archive.mode')[$salereport->mode] : '-',
            $salereport->total_items,
            $salereport->total,
        ];
    }

    public function headings(): array
    {
        return [['SALES REPORT'], [], [
            'SALES ID',
            'NAME',
            'PAYMENT MODE',
            'TOTAL ITEMS',
            'TOTAL',
        ],
        ];
    }

}
