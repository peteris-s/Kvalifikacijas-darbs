@extends('layouts.app')

@section('title', 'Atskaites priekšskatījums | StockManager')
@section('page-title', 'Atskaites')

@section('content')

<!-- HEADER -->
<div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

    <div>

        <a
            href="{{ route('reports.index') }}"
            class="mb-5 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-300"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6"/>
            </svg>

            Atpakaļ uz atskaitēm
        </a>

        <div class="mb-3">

            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Atskaites priekšskatījums
                </span>

            </div>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">

            @if($reportType === 'stock')
                Preču atlikumu atskaite
            @elseif($reportType === 'receipts')
                Preču saņemšanas atskaite
            @elseif($reportType === 'inventory')
                Inventarizācijas atskaite
            @endif

        </h1>

        @if($reportType !== 'stock')

            <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-400">

                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <path d="M16 3v4"/>
                    <path d="M8 3v4"/>
                    <path d="M3 11h18"/>
                </svg>

                <span>Periods:</span>

                <span class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d.m.Y') : 'Sākot no pirmā ieraksta' }}
                </span>

                <span>—</span>

                <span class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d.m.Y') : 'Līdz šodienai' }}
                </span>

            </div>

        @else

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Pašreizējais noliktavas stāvoklis
            </p>

        @endif

    </div>


    <!-- DOWNLOAD BUTTONS -->
    <div class="flex flex-col gap-3 sm:flex-row">

        <a
            href="{{ route('reports.pdf', [
                'report_type' => $reportType,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-bold text-red-700 transition hover:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                <path d="M14 2v6h6"/>
                <path d="M12 12v6"/>
                <path d="m9 15 3 3 3-3"/>
            </svg>

            PDF
        </a>

        <a
            href="{{ route('reports.excel', [
                'report_type' => $reportType,
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                <path d="M14 2v6h6"/>
                <path d="M12 12v6"/>
                <path d="m9 15 3 3 3-3"/>
            </svg>

            Excel
        </a>

    </div>

</div>


<!-- ============================================================ -->
<!-- STOCK REPORT -->
<!-- ============================================================ -->

@if($reportType === 'stock')

    <!-- STATISTICS -->
    <div class="mb-6 grid gap-4 md:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                Preču skaits
            </p>

            <div class="mt-3 flex items-end justify-between">

                <p class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ $data->count() }}
                </p>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                    </svg>

                </div>

            </div>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                Kopējais vienību skaits
            </p>

            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $data->sum('quantity') }}
            </p>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                gab.
            </p>

        </div>


        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm dark:border-amber-400/20 dark:bg-amber-400/[0.08]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-amber-600 dark:text-amber-300">
                Preces ar zemu atlikumu
            </p>

            <p class="mt-3 text-3xl font-bold text-amber-700 dark:text-amber-300">
                {{
                    $data->filter(function ($product) {
                        return $product->quantity <= $product->minimum_quantity;
                    })->count()
                }}
            </p>

            <p class="mt-1 text-xs text-amber-700/70 dark:text-amber-300/70">
                Nepieciešama uzmanība
            </p>

        </div>

    </div>


    <!-- TABLE -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

            <h2 class="font-bold text-slate-900 dark:text-white">
                Preču atlikumi
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Pašreizējais noliktavas preču stāvoklis
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                    <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        <th class="px-6 py-3">Prece</th>
                        <th class="px-6 py-3">Kategorija</th>
                        <th class="px-6 py-3">Atrašanās vieta</th>
                        <th class="px-6 py-3">Cena</th>
                        <th class="px-6 py-3">Atlikums</th>
                        <th class="px-6 py-3">Minimums</th>
                        <th class="px-6 py-3">Statuss</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                    @forelse($data as $product)

                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                            <td class="px-6 py-5 font-bold text-slate-900 dark:text-white">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-5">

                                <span class="rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-white/[0.05] dark:text-slate-300">
                                    {{ $product->category->name ?? '-' }}
                                </span>

                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500 dark:text-slate-400">

                                @if($product->warehouseLocation)

                                    <div class="flex items-center gap-1.5">

                                        <span>
                                            {{ $product->warehouseLocation->parent?->name ?? 'Bez zonas' }}
                                        </span>

                                        <svg class="h-3 w-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="m9 18 6-6-6-6"/>
                                        </svg>

                                        <span class="font-semibold text-slate-700 dark:text-slate-300">
                                            {{ $product->warehouseLocation->name }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-slate-400 dark:text-slate-500">
                                        Nav norādīta
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 font-semibold text-slate-700 dark:text-slate-300">
                                €{{ number_format($product->price, 2) }}
                            </td>

                            <td class="px-6 py-5">

                                <span class="font-bold text-slate-900 dark:text-white">
                                    {{ $product->quantity }}
                                </span>

                                <span class="text-xs text-slate-400">
                                    gab.
                                </span>

                            </td>

                            <td class="px-6 py-5 text-sm font-semibold text-slate-600 dark:text-slate-300">
                                {{ $product->minimum_quantity }} gab.
                            </td>

                            <td class="px-6 py-5">

                                @if($product->quantity <= $product->minimum_quantity)

                                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">

                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                        Zems atlikums
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Pieejams
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-16 text-center">

                                <p class="font-bold text-slate-700 dark:text-slate-300">
                                    Nav atrasta neviena prece
                                </p>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Atskaitē pašlaik nav datu.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif


<!-- ============================================================ -->
<!-- RECEIPTS REPORT -->
<!-- ============================================================ -->

@if($reportType === 'receipts')

    <div class="mb-6 grid gap-4 md:grid-cols-2">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                Pavadzīmju skaits
            </p>

            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $data->count() }}
            </p>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Reģistrētas piegādes
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                Kopā saņemtās vienības
            </p>

            <div class="mt-3 flex items-end gap-2">

                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-300">
                    {{
                        $data->sum(function ($document) {
                            return $document->receipts->sum('quantity');
                        })
                    }}
                </p>

                <span class="mb-1 text-sm text-slate-400">
                    gab.
                </span>

            </div>

        </div>

    </div>


    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

            <h2 class="font-bold text-slate-900 dark:text-white">
                Preču saņemšanas vēsture
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Piegādes izvēlētajā laika periodā
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                    <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        <th class="px-6 py-3">Pavadzīmes Nr.</th>
                        <th class="px-6 py-3">Preces</th>
                        <th class="px-6 py-3">Kopā</th>
                        <th class="px-6 py-3">Datums</th>
                        <th class="px-6 py-3">Reģistrēja</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                    @forelse($data as $document)

                        <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                            <td class="px-6 py-5">

                                <span class="inline-flex rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                    {{ $document->document_number }}
                                </span>

                            </td>

                            <td class="px-6 py-5">

                                <div class="space-y-2">

                                    @foreach($document->receipts as $receipt)

                                        <div class="flex items-center gap-2">

                                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                                {{ $receipt->product->name ?? 'Dzēsta prece' }}
                                            </span>

                                            <span class="rounded-lg bg-emerald-100 px-2 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                                +{{ $receipt->quantity }}
                                            </span>

                                        </div>

                                    @endforeach

                                </div>

                            </td>

                            <td class="px-6 py-5 font-bold text-slate-900 dark:text-white">
                                {{ $document->receipts->sum('quantity') }} gab.
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500 dark:text-slate-400">
                                {{ $document->received_at->format('d.m.Y H:i') }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold uppercase text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                        {{ mb_substr($document->user->name ?? '?', 0, 1) }}
                                    </div>

                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300">
                                        {{ $document->user->name ?? '-' }}
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <p class="font-bold text-slate-700 dark:text-slate-300">
                                    Nav preču saņemšanas ierakstu
                                </p>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Izvēlētajā periodā nav atrasta neviena piegāde.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif


<!-- ============================================================ -->
<!-- INVENTORY REPORT -->
<!-- ============================================================ -->

@if($reportType === 'inventory')

    <div class="mb-6 grid gap-4 md:grid-cols-3">

        <!-- COUNT -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                Korekciju skaits
            </p>

            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $data->count() }}
            </p>

        </div>


        <!-- SHORTAGE -->
        <div class="rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-400/20 dark:bg-red-400/[0.08]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-red-600 dark:text-red-300">
                Konstatēts iztrūkums
            </p>

            <div class="mt-3 flex items-end gap-2">

                <p class="text-3xl font-bold text-red-700 dark:text-red-300">
                    {{
                        abs(
                            $data
                                ->where('difference', '<', 0)
                                ->sum('difference')
                        )
                    }}
                </p>

                <span class="mb-1 text-sm font-medium text-red-600/70 dark:text-red-300/70">
                    gab.
                </span>

            </div>

        </div>


        <!-- SURPLUS -->
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm dark:border-emerald-400/20 dark:bg-emerald-400/[0.08]">

            <p class="text-xs font-bold uppercase tracking-[0.1em] text-emerald-600 dark:text-emerald-300">
                Konstatēts pārpalikums
            </p>

            <div class="mt-3 flex items-end gap-2">

                <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">
                    {{
                        $data
                            ->where('difference', '>', 0)
                            ->sum('difference')
                    }}
                </p>

                <span class="mb-1 text-sm font-medium text-emerald-600/70 dark:text-emerald-300/70">
                    gab.
                </span>

            </div>

        </div>

    </div>


    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

            <h2 class="font-bold text-slate-900 dark:text-white">
                Inventarizācijas vēsture
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Atlikumu korekcijas izvēlētajā laika periodā
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                    <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        <th class="px-6 py-3">Prece</th>
                        <th class="px-6 py-3">Sistēmā bija</th>
                        <th class="px-6 py-3">Faktiski</th>
                        <th class="px-6 py-3">Starpība</th>
                        <th class="px-6 py-3">Iemesls</th>
                        <th class="px-6 py-3">Datums</th>
                        <th class="px-6 py-3">Veica</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                    @forelse($data as $adjustment)

                        <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                            <td class="px-6 py-5 font-bold text-slate-900 dark:text-white">
                                {{ $adjustment->product->name ?? 'Dzēsta prece' }}
                            </td>

                            <td class="px-6 py-5 text-sm font-medium text-slate-600 dark:text-slate-300">
                                {{ $adjustment->system_quantity }} gab.
                            </td>

                            <td class="px-6 py-5 font-semibold text-slate-900 dark:text-white">
                                {{ $adjustment->actual_quantity }} gab.
                            </td>

                            <td class="px-6 py-5">

                                @if($adjustment->difference > 0)

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                        +{{ $adjustment->difference }}
                                    </span>

                                @elseif($adjustment->difference < 0)

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 dark:bg-red-400/10 dark:text-red-300">
                                        {{ $adjustment->difference }}
                                    </span>

                                @else

                                    <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 dark:bg-white/[0.06] dark:text-slate-300">
                                        0
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5">

                                <p class="font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $adjustment->reason }}
                                </p>

                                @if($adjustment->notes)

                                    <p class="mt-1 max-w-xs text-sm text-slate-500 dark:text-slate-400">
                                        {{ $adjustment->notes }}
                                    </p>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500 dark:text-slate-400">
                                {{ $adjustment->adjusted_at->format('d.m.Y H:i') }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold uppercase text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                        {{ mb_substr($adjustment->user->name ?? '?', 0, 1) }}
                                    </div>

                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300">
                                        {{ $adjustment->user->name ?? '-' }}
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-16 text-center">

                                <p class="font-bold text-slate-700 dark:text-slate-300">
                                    Nav inventarizācijas ierakstu
                                </p>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Izvēlētajā periodā nav atrasta neviena korekcija.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endif

@endsection