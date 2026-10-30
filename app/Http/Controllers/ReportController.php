<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Product;
use App\Models\StockReceiptDocument;
use App\Models\InventoryAdjustment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $query = $this->getReportQuery(
            $reportType,
            $dateFrom,
            $dateTo
        );

        $data = $query
            ->paginate(15)
            ->withQueryString();

        $stats = $this->getReportStats(
            $reportType,
            $dateFrom,
            $dateTo
        );

        return view('reports.preview', compact(
            'reportType',
            'dateFrom',
            'dateTo',
            'data',
            'stats'
        ));
    }

    public function excel(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['report_type'];
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        // Eksportā iekļauj visus atlasītos ierakstus.
        $data = $this->getReportQuery(
            $reportType,
            $dateFrom,
            $dateTo
        )->get();

        $fileName = $this->getFileName(
            $reportType,
            'xlsx'
        );

        return Excel::download(
            new ReportExport($data, $reportType),
            $fileName
        );
    }

    public function pdf(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['report_type'];
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        // PDF eksportā iekļauj visus atlasītos ierakstus.
        $data = $this->getReportQuery(
            $reportType,
            $dateFrom,
            $dateTo
        )->get();

        $pdf = Pdf::loadView('reports.pdf', compact(
            'reportType',
            'dateFrom',
            'dateTo',
            'data'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            $this->getFileName($reportType, 'pdf')
        );
    }

    private function validateReportRequest(Request $request): array
    {
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

    private function getReportQuery(
        string $reportType,
        ?string $dateFrom,
        ?string $dateTo
    ) {
        // PREČU ATLIKUMU ATSKAITE
        if ($reportType === 'stock') {
            return Product::with([
                'category',
                'warehouseLocation.parent',
            ])
                ->orderBy('name')
                ->orderBy('id');
        }

        // PREČU SAŅEMŠANAS ATSKAITE
        if ($reportType === 'receipts') {
            $query = StockReceiptDocument::with([
                'user',
                'receipts.product',
            ]);

            $this->applyDateFilters(
                $query,
                'received_at',
                $dateFrom,
                $dateTo
            );

            return $query
                ->orderByDesc('received_at')
                ->orderByDesc('id');
        }

        // INVENTARIZĀCIJAS ATSKAITE
        $query = InventoryAdjustment::with([
            'product',
            'user',
        ]);

        $this->applyDateFilters(
            $query,
            'adjusted_at',
            $dateFrom,
            $dateTo
        );

        return $query
            ->orderByDesc('adjusted_at')
            ->orderByDesc('id');
    }

    private function applyDateFilters(
        $query,
        string $column,
        ?string $dateFrom,
        ?string $dateTo
    ): void {
        if ($dateFrom) {
            $query->whereDate($column, '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate($column, '<=', $dateTo);
        }
    }

    private function getReportStats(
        string $reportType,
        ?string $dateFrom,
        ?string $dateTo
    ): array {
        // PREČU ATLIKUMU STATISTIKA
        if ($reportType === 'stock') {
            return [
                'count' => Product::count(),

                'total_quantity' => Product::sum('quantity'),

                'low_stock' => Product::whereColumn(
                    'quantity',
                    '<=',
                    'minimum_quantity'
                )->count(),
            ];
        }

        // PREČU SAŅEMŠANAS STATISTIKA
        if ($reportType === 'receipts') {
            $query = StockReceiptDocument::query();

            $this->applyDateFilters(
                $query,
                'received_at',
                $dateFrom,
                $dateTo
            );

            $documentCount = (clone $query)->count();

            // Ar cursor() netiek ielādētas visas
            // pavadzīmes atmiņā vienlaikus.
            $totalQuantity = 0;

            foreach (
                (clone $query)
                    ->withSum('receipts', 'quantity')
                    ->cursor() as $document
            ) {
                $totalQuantity +=
                    (int) ($document->receipts_sum_quantity ?? 0);
            }

            return [
                'count' => $documentCount,
                'total_quantity' => $totalQuantity,
            ];
        }

        // INVENTARIZĀCIJAS STATISTIKA
        $query = InventoryAdjustment::query();

        $this->applyDateFilters(
            $query,
            'adjusted_at',
            $dateFrom,
            $dateTo
        );

        return [
            'count' => (clone $query)->count(),

            'shortage' => (int) (clone $query)->sum(
                DB::raw(
                    'CASE WHEN difference < 0 THEN -difference ELSE 0 END'
                )
            ),

            'surplus' => (int) (clone $query)->sum(
                DB::raw(
                    'CASE WHEN difference > 0 THEN difference ELSE 0 END'
                )
            ),
        ];
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
