<?php

namespace App\Export\Admin\Reports\Salereport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AmountcdreportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    private $amountcdreport;

    public function __construct($amountcdreport)
    {
        $this->amountcdreport = $amountcdreport;
    }

    public function collection()
    {
        return $this->amountcdreport;
    }

    public function map($amountcdreport): array
    {
        return [

            $amountcdreport->amountcdable->uniqid,
            $amountcdreport->credit,
            $amountcdreport->debit,
            $amountcdreport->balance,
            $amountcdreport->created_at,
        ];
    }

    public function headings(): array
    {
        return [['CREDIT / DEBIT REPORT'], [], [
            'REFERENCE ID',
            'CREDIT',
            'DEBIT',
            'BALANCE',
            'CREATED AT',
        ],
        ];
    }

}
