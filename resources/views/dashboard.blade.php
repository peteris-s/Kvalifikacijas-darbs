@extends('layouts.app')

@section('title', 'Pārskats | StockManager')

@section('page-title', 'Pārskats')

@section('content')

    <!-- HERO / WELCOME -->
    <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Noliktavas pārskats
                </span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white dark:text-white lg:text-4xl">
                Sveiks, {{ auth()->user()->name }}!
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Pārskati noliktavas situāciju, pasūtījumus un preču atlikumus vienuviet.
            </p>
        </div>


        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('customer-orders.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-300 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:text-slate-200 dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                    <path d="M3 6h18"/>
                </svg>

                Pasūtījumi
            </a>


            <a
                href="{{ route('stock-receipts.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#0b1614] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600 dark:bg-emerald-400 dark:text-[#07110f] dark:hover:bg-emerald-300"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>

                Reģistrēt saņemšanu
            </a>

        </div>

    </div>


    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-5">

        <!-- PRODUCTS -->
        <a
            href="{{ route('products.index') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-emerald-400/40 dark:hover:bg-[#10221e]"
        >
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-emerald-50 dark:bg-emerald-400/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="m7.5 4.27 9 5.15"/>
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>

                    </div>

                    <svg
                        class="h-4 w-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-emerald-500"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </div>

                <p class="mt-5 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Kopā preces
                </p>

                <div class="mt-1 flex items-end gap-2">
                    <p class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $totalProducts }}
                    </p>

                    <span class="mb-1 text-xs font-medium text-slate-400 dark:text-slate-500 dark:text-slate-500">
                        preces
                    </span>
                </div>

            </div>
        </a>


        <!-- LOW STOCK -->
        <a
            href="{{ route('products.index', ['stock' => 'low']) }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-orange-200 hover:shadow-md dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-orange-400/30 dark:hover:bg-[#10221e]"
        >
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-orange-50 dark:bg-orange-400/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-500 dark:bg-orange-400/10 dark:text-orange-400">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                            <path d="M10.3 2.9 1.8 17a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 2.9a2 2 0 0 0-3.4 0Z"/>
                        </svg>

                    </div>

                    @if($lowStockProducts > 0)
                        <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-orange-700">
                            Uzmanību
                        </span>
                    @else
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                            Kārtībā
                        </span>
                    @endif

                </div>

                <p class="mt-5 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Zems atlikums
                </p>

                <div class="mt-1 flex items-end gap-2">

                    <p class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $lowStockProducts }}
                    </p>

                    <span class="mb-1 text-xs font-medium text-slate-400 dark:text-slate-500 dark:text-slate-500">
                        preces
                    </span>

                </div>

            </div>
        </a>


        <!-- PENDING ORDERS -->
        <a
            href="{{ route('customer-orders.index') }}"
            class="group relative overflow-hidden rounded-2xl border
            {{ $pendingOrders > 0
                ? 'border-amber-200 bg-amber-50/60 dark:border-amber-400/35 dark:bg-amber-400/10'
                : 'border-slate-200 bg-white dark:border-emerald-400/15 dark:bg-[#0d1b18]' }}
            p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-amber-100/60 dark:bg-amber-400/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-400/15 dark:text-amber-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>

                    </div>

                    @if($pendingOrders > 0)

                        <span class="flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            Jāapstrādā
                        </span>

                    @else

                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                            Kārtībā
                        </span>

                    @endif

                </div>

                <p class="mt-5 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Gaida izsniegšanu
                </p>

                <div class="mt-1 flex items-end gap-2">

                    <p class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $pendingOrders }}
                    </p>

                    <span class="mb-1 text-xs font-medium text-slate-400 dark:text-slate-500 dark:text-slate-500">
                        pasūtījumi
                    </span>

                </div>

            </div>
        </a>


        <!-- RECEIPTS -->
        <a
            href="{{ route('stock-receipts.index') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-sky-200 hover:shadow-md dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-emerald-400/40 dark:hover:bg-[#10221e]"
        >
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-sky-50 dark:bg-emerald-400/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3v12"/>
                            <path d="m7 10 5 5 5-5"/>
                            <path d="M5 21h14"/>
                        </svg>

                    </div>

                </div>

                <p class="mt-5 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Saņemšanas dokumenti
                </p>

                <div class="mt-1 flex items-end gap-2">

                    <p class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $totalReceipts }}
                    </p>

                    <span class="mb-1 text-xs font-medium text-slate-400 dark:text-slate-500 dark:text-slate-500">
                        dokumenti
                    </span>

                </div>

            </div>
        </a>


        <!-- INVENTORY -->
        <a
            href="{{ route('inventory-adjustments.index') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-violet-200 hover:shadow-md dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-emerald-400/40 dark:hover:bg-[#10221e]"
        >
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-violet-50 dark:bg-emerald-400/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>

                    </div>

                </div>

                <p class="mt-5 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Inventarizācijas
                </p>

                <div class="mt-1 flex items-end gap-2">

                    <p class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $totalAdjustments }}
                    </p>

                    <span class="mb-1 text-xs font-medium text-slate-400 dark:text-slate-500 dark:text-slate-500">
                        korekcijas
                    </span>

                </div>

            </div>
        </a>

    </div>


    <!-- MAIN DASHBOARD CONTENT -->
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-5">

        <!-- LATEST RECEIPTS -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-3 dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3v12"/>
                            <path d="m7 10 5 5 5-5"/>
                            <path d="M5 21h14"/>
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-bold text-slate-900 dark:text-white">
                            Jaunākās preču saņemšanas
                        </h3>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Pēdējie noliktavā reģistrētie dokumenti
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('stock-receipts.index') }}"
                    class="text-xs font-bold text-emerald-600 transition hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                >
                    Skatīt visas →
                </a>

            </div>


            @if($latestReceipts->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr class="border-b border-slate-100 bg-slate-50/70 text-left dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                    Pavadzīmes Nr.
                                </th>

                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                    Daudzums
                                </th>

                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                    Datums
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                            @foreach($latestReceipts as $document)

                                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-emerald-400/10 dark:text-emerald-300">

                                                <svg
                                                    class="h-4 w-4"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                                                    <path d="M14 2v6h6"/>
                                                </svg>

                                            </div>

                                            <div>

                                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                                    {{ $document->document_number }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                                    {{ $document->user->name ?? '-' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    <td class="px-6 py-4">

                                        <span class="rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-bold text-slate-700 dark:bg-emerald-400/10 dark:text-emerald-200">
                                            {{ $document->receipts->sum('quantity') }} gab.
                                        </span>

                                    </td>


                                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $document->received_at->format('d.m.Y H:i') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3v12"/>
                            <path d="m7 10 5 5 5-5"/>
                            <path d="M5 21h14"/>
                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Nav reģistrētu saņemšanu
                    </p>

                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                        Reģistrē pirmo piegādātāja dokumentu.
                    </p>

                    <a
                        href="{{ route('stock-receipts.create') }}"
                        class="mt-4 inline-flex text-sm font-bold text-emerald-600 hover:text-emerald-700"
                    >
                        Reģistrēt saņemšanu →
                    </a>

                </div>

            @endif

        </div>


        <!-- RESTOCK -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2 dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-500 dark:bg-orange-400/10 dark:text-orange-400">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M3 3v18h18"/>
                            <path d="m7 16 4-5 4 3 5-7"/>
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-bold text-slate-900 dark:text-white">
                            Nepieciešams papildināt
                        </h3>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Kritiskākie preču atlikumi
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('purchase-planning.index') }}"
                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                >
                    Skatīt →
                </a>

            </div>


            @if($restockProducts->count() > 0)

                <div class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                    @foreach($restockProducts as $product)

                        @php
                            $minimum = max(1, $product->minimum_quantity);

                            $stockPercentage = min(
                                100,
                                max(
                                    0,
                                    ($product->quantity / $minimum) * 100
                                )
                            );
                        @endphp

                        <div class="px-6 py-5">

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-100 dark:text-slate-100">
                                        {{ $product->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                        {{ $product->category->name ?? 'Bez kategorijas' }}
                                    </p>

                                </div>


                                @if($product->quantity == 0)

                                    <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-600">
                                        Nav atlikuma
                                    </span>

                                @else

                                    <span class="shrink-0 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-bold text-orange-600">
                                        {{ $product->quantity }} gab.
                                    </span>

                                @endif

                            </div>


                            <div class="mt-4">

                                <div class="mb-2 flex items-center justify-between text-[11px]">

                                    <span class="font-medium text-slate-400 dark:text-slate-500">
                                        Noliktavas atlikums
                                    </span>

                                    <span class="font-semibold text-slate-500 dark:text-slate-400">
                                        {{ $product->quantity }} / {{ $product->minimum_quantity }} gab.
                                    </span>

                                </div>


                                <div class="h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-white/[0.07]">

                                    <div
                                        class="h-full rounded-full
                                        {{ $product->quantity == 0
                                            ? 'bg-red-400'
                                            : 'bg-orange-400' }}"
                                        style="width: {{ $stockPercentage }}%"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500">

                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="m5 12 4 4L19 6"/>
                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-bold text-slate-700 dark:text-slate-200">
                        Atlikumi ir pietiekami
                    </p>

                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                        Pašlaik nekas nav jāpapildina.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <!-- QUICK ACTIONS -->
    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="flex items-center justify-between">

            <div>

                <h3 class="font-bold text-slate-900 dark:text-white">
                    Ātrās darbības
                </h3>

                <p class="mt-1 text-xs text-slate-500">
                    Biežāk izmantotās noliktavas funkcijas
                </p>

            </div>

            <span class="hidden rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500 dark:bg-emerald-400/10 dark:text-emerald-300 sm:inline-flex">
                Ātrā piekļuve
            </span>

        </div>


        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">

            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('products.create') }}"
                    class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-emerald-400/15 dark:bg-[#10201d] dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10"
                >

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-400 group-hover:text-[#0b1614]">

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-100">
                        Pievienot preci
                    </p>

                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                        Jauna prece katalogā
                    </p>

                </a>

            @endif


            <a
                href="{{ route('customer-orders.index') }}"
                class="group rounded-xl border border-slate-200 p-4 transition hover:border-amber-300 hover:bg-amber-50/50 dark:border-emerald-400/15 dark:bg-[#10201d] dark:hover:border-amber-400/40 dark:hover:bg-amber-400/10"
            >

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-300">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/>
                    </svg>

                </div>

                <p class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-100">
                    Pasūtījumi
                </p>

                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                    {{ $pendingOrders }} gaida izsniegšanu
                </p>

            </a>


            <a
                href="{{ route('stock-receipts.create') }}"
                class="group rounded-xl border border-slate-200 p-4 transition hover:border-sky-300 hover:bg-sky-50/50 dark:border-emerald-400/15 dark:bg-[#10201d] dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10"
            >

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 3v12"/>
                        <path d="m7 10 5 5 5-5"/>
                        <path d="M5 21h14"/>
                    </svg>

                </div>

                <p class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-100">
                    Preču saņemšana
                </p>

                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                    Reģistrēt pavadzīmi
                </p>

            </a>


            <a
                href="{{ route('inventory-adjustments.create') }}"
                class="group rounded-xl border border-slate-200 p-4 transition hover:border-violet-300 hover:bg-violet-50/50 dark:border-emerald-400/15 dark:bg-[#10201d] dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10"
            >

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M9 11 12 14 22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>

                </div>

                <p class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-100">
                    Inventarizācija
                </p>

                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                    Reģistrēt korekciju
                </p>

            </a>


            <a
                href="{{ route('reports.index') }}"
                class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-emerald-400/15 dark:bg-[#10201d] dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10"
            >

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M3 3v18h18"/>
                        <path d="M7 16v-5"/>
                        <path d="M12 16V8"/>
                        <path d="M17 16V5"/>
                    </svg>

                </div>

                <p class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-100">
                    Atskaites
                </p>

                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                    PDF un Excel
                </p>

            </a>

        </div>

    </div>

@endsection