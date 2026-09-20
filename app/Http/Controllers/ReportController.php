<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Product;
use App\Models\StockReceiptDocument;
use App\Models\InventoryAdjustment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function preview(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['report_type'];
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $data = $this->getReportData(
            $reportType,
            $dateFrom,
            $dateTo
        );

        return view(
            'reports.preview',
            compact(
                'reportType',
                'dateFrom',
                'dateTo',
                'data'
            )
        );
    }

    public function excel(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['report_type'];
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $data = $this->getReportData(
            $reportType,
            $dateFrom,
            $dateTo
        );

        $fileName = $this->getFileName(
            $reportType,
            'xlsx'
        );

        return Excel::download(
            new ReportExport(
                $data,
                $reportType
            ),
            $fileName
        );
    }

    public function pdf(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['report_type'];
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $data = $this->getReportData(
            $reportType,
            $dateFrom,
            $dateTo
        );

        $pdf = Pdf::loadView(
            'reports.pdf',
            compact(
                'reportType',
                'dateFrom',
                'dateTo',
                'data'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        $fileName = $this->getFileName(
            $reportType,
            'pdf'
        );

        return $pdf->download($fileName);
    }

    private function validateReportRequest(
        Request $request
    ): array {
        return $request->validate([
            'report_type' => [
                'required',
                'in:stock,receipts,inventory',
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);
    }

    private function getReportData(
        string $reportType,
        ?string $dateFrom,
        ?string $dateTo
    ) {
        /*
        |--------------------------------------------------------------------------
        | PREČU ATLIKUMU ATSKAITE
        |--------------------------------------------------------------------------
        */

        if ($reportType === 'stock') {

            return Product::with([
                'category',
                'warehouseLocation.parent',
            ])
                ->orderBy('name')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | PREČU SAŅEMŠANAS ATSKAITE
        |--------------------------------------------------------------------------
        */

        if ($reportType === 'receipts') {

            $query = StockReceiptDocument::with([
                'user',
                'receipts.product',
            ]);

            if ($dateFrom) {
                $query->whereDate(
                    'received_at',
                    '>=',
                    $dateFrom
                );
            }

            if ($dateTo) {
                $query->whereDate(
                    'received_at',
                    '<=',
                    $dateTo
                );
            }

            return $query
                ->orderByDesc('received_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | INVENTARIZĀCIJAS ATSKAITE
        |--------------------------------------------------------------------------
        */

        $query = InventoryAdjustment::with([
            'product',
            'user',
        ]);

        if ($dateFrom) {
            $query->whereDate(
                'adjusted_at',
                '>=',
                $dateFrom
            );
        }

        if ($dateTo) {
            $query->whereDate(
                'adjusted_at',
                '<=',
                $dateTo
            );
        }

        return $query
            ->orderByDesc('adjusted_at')
            ->get();
    }

    private function getFileName(
        string $reportType,
        string $extension
    ): string {
        $name = match ($reportType) {
            'stock' => 'precu-atlikumi',
            'receipts' => 'precu-sanemsana',
            'inventory' => 'inventarizacija',
        };

        return $name
            . '-'
            . now()->format('Y-m-d-His')
            . '.'
            . $extension;
    }
}