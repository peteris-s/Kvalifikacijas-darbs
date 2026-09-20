<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">

    <title>
        @if($reportType === 'stock')
            Preču atlikumu atskaite
        @elseif($reportType === 'receipts')
            Preču saņemšanas atskaite
        @else
            Inventarizācijas atskaite
        @endif
    </title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
        }

        h1 {
            margin: 0 0 5px 0;
            font-size: 22px;
        }

        .subtitle {
            margin-bottom: 20px;
            color: #6b7280;
        }

        .info {
            margin-bottom: 18px;
            padding: 10px;
            background: #f3f4f6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 8px;
            border: 1px solid #d1d5db;
            background: #e5e7eb;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 7px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .low {
            font-weight: bold;
        }

        .positive {
            font-weight: bold;
        }

        .negative {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>

<body>

<h1>
    @if($reportType === 'stock')
        Preču atlikumu atskaite
    @elseif($reportType === 'receipts')
        Preču saņemšanas atskaite
    @else
        Inventarizācijas atskaite
    @endif
</h1>

<div class="subtitle">
    StockManager
</div>


<div class="info">

    <strong>Atskaites izveides datums:</strong>
    {{ now()->format('d.m.Y H:i') }}

    @if($reportType !== 'stock')

        <br>

        <strong>Periods:</strong>

        {{ $dateFrom
            ? \Carbon\Carbon::parse($dateFrom)->format('d.m.Y')
            : 'No pirmā ieraksta'
        }}

        —

        {{ $dateTo
            ? \Carbon\Carbon::parse($dateTo)->format('d.m.Y')
            : 'Līdz šodienai'
        }}

    @endif

</div>


{{-- ========================================================= --}}
{{-- PREČU ATLIKUMI --}}
{{-- ========================================================= --}}

@if($reportType === 'stock')

<table>

    <thead>
        <tr>
            <th>Prece</th>
            <th>Kategorija</th>
            <th>Atrašanās vieta</th>
            <th>Cena</th>
            <th>Atlikums</th>
            <th>Minimums</th>
            <th>Statuss</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $product)

        <tr>

            <td>
                {{ $product->name }}
            </td>

            <td>
                {{ $product->category->name ?? '-' }}
            </td>

            <td>

                @if($product->warehouseLocation)

                    {{ $product->warehouseLocation->parent?->name ?? 'Bez zonas' }}
                    →
                    {{ $product->warehouseLocation->name }}

                @else

                    Nav norādīta

                @endif

            </td>

            <td>
                €{{ number_format($product->price, 2, ',', ' ') }}
            </td>

            <td>
                {{ $product->quantity }}
            </td>

            <td>
                {{ $product->minimum_quantity }}
            </td>

            <td>

                @if($product->quantity <= $product->minimum_quantity)

                    <span class="low">
                        Zems atlikums
                    </span>

                @else

                    Pieejams

                @endif

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="7">
                Nav atrasta neviena prece.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

@endif


{{-- ========================================================= --}}
{{-- PREČU SAŅEMŠANA --}}
{{-- ========================================================= --}}

@if($reportType === 'receipts')

<table>

    <thead>
        <tr>
            <th>Pavadzīmes Nr.</th>
            <th>Preces</th>
            <th>Kopā</th>
            <th>Datums</th>
            <th>Reģistrēja</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $document)

        <tr>

            <td>
                {{ $document->document_number }}
            </td>

            <td>

                @foreach($document->receipts as $receipt)

                    {{ $receipt->product->name ?? 'Dzēsta prece' }}
                    (+{{ $receipt->quantity }})

                    @if(!$loop->last)
                        <br>
                    @endif

                @endforeach

            </td>

            <td>
                {{ $document->receipts->sum('quantity') }} gab.
            </td>

            <td>
                {{ $document->received_at->format('d.m.Y H:i') }}
            </td>

            <td>
                {{ $document->user->name ?? '-' }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="5">
                Izvēlētajā periodā nav preču saņemšanas ierakstu.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

@endif


{{-- ========================================================= --}}
{{-- INVENTARIZĀCIJA --}}
{{-- ========================================================= --}}

@if($reportType === 'inventory')

<table>

    <thead>
        <tr>
            <th>Prece</th>
            <th>Sistēmā bija</th>
            <th>Faktiski</th>
            <th>Starpība</th>
            <th>Iemesls</th>
            <th>Piezīmes</th>
            <th>Datums</th>
            <th>Veica</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $adjustment)

        <tr>

            <td>
                {{ $adjustment->product->name ?? 'Dzēsta prece' }}
            </td>

            <td>
                {{ $adjustment->system_quantity }}
            </td>

            <td>
                {{ $adjustment->actual_quantity }}
            </td>

            <td>

                @if($adjustment->difference > 0)

                    <span class="positive">
                        +{{ $adjustment->difference }}
                    </span>

                @elseif($adjustment->difference < 0)

                    <span class="negative">
                        {{ $adjustment->difference }}
                    </span>

                @else

                    0

                @endif

            </td>

            <td>
                {{ $adjustment->reason }}
            </td>

            <td>
                {{ $adjustment->notes ?? '-' }}
            </td>

            <td>
                {{ $adjustment->adjusted_at->format('d.m.Y H:i') }}
            </td>

            <td>
                {{ $adjustment->user->name ?? '-' }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="8">
                Izvēlētajā periodā nav inventarizācijas ierakstu.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

@endif


<div class="footer">
    Atskaite automātiski ģenerēta StockManager sistēmā.
</div>

</body>
</html>