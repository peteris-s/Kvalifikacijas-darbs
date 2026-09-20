@extends('layouts.app')

@section('title', 'Atskaites priekšskatījums | StockManager')

@section('page-title', 'Atskaites')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <a
            href="{{ route('reports.index') }}"
            class="text-sm font-medium text-blue-600 hover:underline">
            ← Atpakaļ uz atskaitēm
        </a>

        <h1 class="mt-3 text-3xl font-bold text-gray-800">

            @if($reportType === 'stock')
                Preču atlikumu atskaite
            @elseif($reportType === 'receipts')
                Preču saņemšanas atskaite
            @elseif($reportType === 'inventory')
                Inventarizācijas atskaite
            @endif

        </h1>

        @if($reportType !== 'stock')

            <p class="mt-2 text-gray-500">

                Periods:

                <span class="font-medium text-gray-700">
                    {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d.m.Y') : 'Sākot no pirmā ieraksta' }}
                </span>

                —

                <span class="font-medium text-gray-700">
                    {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d.m.Y') : 'Līdz šodienai' }}
                </span>

            </p>

        @endif

    </div>


    <!-- DOWNLOAD BUTTONS -->
    <div class="flex gap-3">

        <a
            href="{{ route('reports.pdf', [
                'report_type' => $reportType,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]) }}"
            class="rounded-lg bg-red-600 px-5 py-3 font-medium text-white transition hover:bg-red-700">
            Lejupielādēt PDF
        </a>

        <a
            href="{{ route('reports.excel', [
                'report_type' => $reportType,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]) }}"
            class="rounded-lg bg-green-600 px-5 py-3 font-medium text-white transition hover:bg-green-700">
            Lejupielādēt Excel
        </a>

    </div>

</div>


<!-- STOCK REPORT -->
@if($reportType === 'stock')

    <div class="mb-6 grid gap-4 md:grid-cols-3">

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Preču skaits
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data->count() }}
            </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Kopējais vienību skaits
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data->sum('quantity') }}
            </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Preces ar zemu atlikumu
            </p>

            <p class="mt-2 text-3xl font-bold text-orange-600">
                {{
                    $data->filter(function ($product) {
                        return $product->quantity <= $product->minimum_quantity;
                    })->count()
                }}
            </p>
        </div>

    </div>


    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">
                        <th class="p-4">Prece</th>
                        <th class="p-4">Kategorija</th>
                        <th class="p-4">Atrašanās vieta</th>
                        <th class="p-4">Cena</th>
                        <th class="p-4">Atlikums</th>
                        <th class="p-4">Minimums</th>
                        <th class="p-4">Statuss</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($data as $product)

                    <tr class="border-b last:border-b-0 hover:bg-gray-50">

                        <td class="p-4 font-semibold text-gray-800">
                            {{ $product->name }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $product->category->name ?? '-' }}
                        </td>

                        <td class="p-4 text-gray-600">

                            @if($product->warehouseLocation)

                                {{ $product->warehouseLocation->parent?->name ?? 'Bez zonas' }}
                                →
                                {{ $product->warehouseLocation->name }}

                            @else

                                Nav norādīta

                            @endif

                        </td>

                        <td class="p-4">
                            €{{ number_format($product->price, 2) }}
                        </td>

                        <td class="p-4 font-semibold">
                            {{ $product->quantity }}
                        </td>

                        <td class="p-4">
                            {{ $product->minimum_quantity }}
                        </td>

                        <td class="p-4">

                            @if($product->quantity <= $product->minimum_quantity)

                                <span class="rounded-full bg-orange-100 px-3 py-1 text-sm font-medium text-orange-700">
                                    Zems atlikums
                                </span>

                            @else

                                <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                                    Pieejams
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-500">
                            Nav atrasta neviena prece.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif


<!-- RECEIPTS REPORT -->
@if($reportType === 'receipts')

    <div class="mb-6 grid gap-4 md:grid-cols-2">

        <div class="rounded-xl bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Pavadzīmju skaits
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data->count() }}
            </p>

        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Kopā saņemtās vienības
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{
                    $data->sum(function ($document) {
                        return $document->receipts->sum('quantity');
                    })
                }}
            </p>

        </div>

    </div>


    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">
                        <th class="p-4">Pavadzīmes Nr.</th>
                        <th class="p-4">Preces</th>
                        <th class="p-4">Kopā</th>
                        <th class="p-4">Datums</th>
                        <th class="p-4">Reģistrēja</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($data as $document)

                    <tr class="border-b align-top last:border-b-0">

                        <td class="p-4 font-semibold text-gray-800">
                            {{ $document->document_number }}
                        </td>

                        <td class="p-4">

                            <div class="space-y-2">

                                @foreach($document->receipts as $receipt)

                                    <div>
                                        {{ $receipt->product->name ?? 'Dzēsta prece' }}

                                        <span class="ml-2 rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                            +{{ $receipt->quantity }}
                                        </span>
                                    </div>

                                @endforeach

                            </div>

                        </td>

                        <td class="p-4 font-semibold">
                            {{ $document->receipts->sum('quantity') }} gab.
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $document->received_at->format('d.m.Y H:i') }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $document->user->name ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            Izvēlētajā periodā nav preču saņemšanas ierakstu.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif


<!-- INVENTORY REPORT -->
@if($reportType === 'inventory')

    <div class="mb-6 grid gap-4 md:grid-cols-3">

        <div class="rounded-xl bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Korekciju skaits
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data->count() }}
            </p>

        </div>


        <div class="rounded-xl bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Konstatēts iztrūkums
            </p>

            <p class="mt-2 text-3xl font-bold text-red-600">

                {{
                    abs(
                        $data
                            ->where('difference', '<', 0)
                            ->sum('difference')
                    )
                }}

                <span class="text-base font-normal">
                    gab.
                </span>

            </p>

        </div>


        <div class="rounded-xl bg-white p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Konstatēts pārpalikums
            </p>

            <p class="mt-2 text-3xl font-bold text-green-600">

                {{
                    $data
                        ->where('difference', '>', 0)
                        ->sum('difference')
                }}

                <span class="text-base font-normal">
                    gab.
                </span>

            </p>

        </div>

    </div>


    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">
                        <th class="p-4">Prece</th>
                        <th class="p-4">Sistēmā bija</th>
                        <th class="p-4">Faktiski</th>
                        <th class="p-4">Starpība</th>
                        <th class="p-4">Iemesls</th>
                        <th class="p-4">Datums</th>
                        <th class="p-4">Veica</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($data as $adjustment)

                    <tr class="border-b last:border-b-0">

                        <td class="p-4 font-semibold text-gray-800">
                            {{ $adjustment->product->name ?? 'Dzēsta prece' }}
                        </td>

                        <td class="p-4">
                            {{ $adjustment->system_quantity }}
                        </td>

                        <td class="p-4">
                            {{ $adjustment->actual_quantity }}
                        </td>

                        <td class="p-4">

                            @if($adjustment->difference > 0)

                                <span class="font-semibold text-green-600">
                                    +{{ $adjustment->difference }}
                                </span>

                            @elseif($adjustment->difference < 0)

                                <span class="font-semibold text-red-600">
                                    {{ $adjustment->difference }}
                                </span>

                            @else

                                <span class="text-gray-500">
                                    0
                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <p class="font-medium text-gray-800">
                                {{ $adjustment->reason }}
                            </p>

                            @if($adjustment->notes)

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $adjustment->notes }}
                                </p>

                            @endif

                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $adjustment->adjusted_at->format('d.m.Y H:i') }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $adjustment->user->name ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-500">
                            Izvēlētajā periodā nav inventarizācijas ierakstu.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif

@endsection