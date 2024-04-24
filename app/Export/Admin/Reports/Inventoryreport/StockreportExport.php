<?php

namespace App\Export\Admin\Reports\Inventoryreport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockreportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    private $stockreport;

    public function __construct($stockreport)
    {
        $this->stockreport = $stockreport;
    }

    public function collection()
    {
        return $this->stockreport;
    }

    public function map($stockreport): array
    {
        switch ($stockreport->stockcdable_type) {
            case ('App\Models\Admin\Product\Product'):
                $stocktype = 'Product';
                break;

            case ('App\Models\Admin\Purchase\Purchase'):
                $stocktype = 'Purchase';
                break;

            case ('App\Models\Admin\Sale\Sale'):
                $stocktype = 'Sale';
                break;

            default:
                $stocktype = '-';
                break;
        }

        return [

            $stockreport->product?->name,
            $stockreport->credit ? $stockreport->credit : '0',
            $stockreport->debit ? $stockreport->debit : '0',
            $stockreport->balace ? $stockreport->balace : '0',
            $stockreport->stockcdable_type ? $stocktype : '-',
            $stockreport->created_at->format('d-m-Y h:i A') ? $stockreport->created_at->format('d-m-Y h:i A') : '',
        ];
    }

    public function headings(): array
    {
        return [['STOCK CREDIT / DEBIT REPORTS'], [], [
            'PRODUCT NAME',
            'CREDIT',
            'DEBIT',
            'BALANCE',
            'TYPE',
            'DATE',
        ],
        ];
    }

}
