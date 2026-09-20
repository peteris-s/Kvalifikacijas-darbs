<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected Collection $data;
    protected string $reportType;

    public function __construct(
        Collection $data,
        string $reportType
    ) {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        if ($this->reportType === 'stock') {
            return [
                'Prece',
                'Kategorija',
                'Noliktavas zona',
                'Plaukts',
                'Cena (€)',
                'Atlikums',
                'Minimālais daudzums',
                'Statuss',
            ];
        }

        if ($this->reportType === 'receipts') {
            return [
                'Pavadzīmes Nr.',
                'Preces',
                'Kopējais daudzums',
                'Saņemšanas datums',
                'Reģistrēja',
            ];
        }

        if ($this->reportType === 'inventory') {
            return [
                'Prece',
                'Sistēmā bija',
                'Faktiskais daudzums',
                'Starpība',
                'Iemesls',
                'Piezīmes',
                'Datums',
                'Veica',
            ];
        }

        return [];
    }

    public function map($row): array
    {
        /*
        |--------------------------------------------------------------------------
        | PREČU ATLIKUMU ATSKAITE
        |--------------------------------------------------------------------------
        */

        if ($this->reportType === 'stock') {
            return [
                $row->name,

                $row->category->name ?? '-',

                $row->warehouseLocation
                    ? ($row->warehouseLocation->parent?->name ?? 'Bez zonas')
                    : 'Nav norādīta',

                $row->warehouseLocation
                    ? $row->warehouseLocation->name
                    : 'Nav norādīts',

                number_format(
                    $row->price,
                    2,
                    '.',
                    ''
                ),

                $row->quantity,

                $row->minimum_quantity,

                $row->quantity <= $row->minimum_quantity
                    ? 'Zems atlikums'
                    : 'Pieejams',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PREČU SAŅEMŠANAS ATSKAITE
        |--------------------------------------------------------------------------
        */

        if ($this->reportType === 'receipts') {

            $products = $row->receipts
                ->map(function ($receipt) {
                    return ($receipt->product->name ?? 'Dzēsta prece')
                        . ' (+' . $receipt->quantity . ')';
                })
                ->implode(', ');

            return [
                $row->document_number,

                $products,

                $row->receipts->sum('quantity'),

                $row->received_at
                    ? $row->received_at->format('d.m.Y H:i')
                    : '-',

                $row->user->name ?? '-',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | INVENTARIZĀCIJAS ATSKAITE
        |--------------------------------------------------------------------------
        */

        if ($this->reportType === 'inventory') {
            return [
                $row->product->name ?? 'Dzēsta prece',

                $row->system_quantity,

                $row->actual_quantity,

                $row->difference,

                $row->reason,

                $row->notes ?? '-',

                $row->adjusted_at
                    ? $row->adjusted_at->format('d.m.Y H:i')
                    : '-',

                $row->user->name ?? '-',
            ];
        }

        return [];
    }
}