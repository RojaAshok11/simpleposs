<?php

namespace App\Export\Admin\Reports\Salereport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SaleitemreportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    private $saleitemreport;

    public function __construct($saleitemreport)
    {
        $this->saleitemreport = $saleitemreport;
    }

    public function collection()
    {
        return $this->saleitemreport;
    }

    public function map($saleitemreport): array
    {
        return [
            $saleitemreport->product_name,
            $saleitemreport->price,
            $saleitemreport->quantity,
            $saleitemreport->total,
        ];
    }

    public function headings(): array
    {
        return [['SALE ITEMS REPORT'], [], [
            'PRODUCT NAME',
            'PRICE',
            'QUANTITY',
            'TOTAL',
        ],
        ];
    }

}
