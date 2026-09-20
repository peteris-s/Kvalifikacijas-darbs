@extends('layouts.app')

@section('title', 'Pārskats | StockManager')

@section('page-title', 'Pārskats')

@section('content')

    <!-- WELCOME -->
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Sveiks, {{ auth()->user()->name }}!
        </h1>

        <p class="mt-1 text-gray-500">
            Noliktavas pārskats
        </p>

    </div>


    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-5">

        <!-- PRODUCTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-gray-500">
                Kopā preces
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalProducts }}
            </p>

            <a
                href="{{ route('products.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline"
            >
                Skatīt preces →
            </a>

        </div>


        <!-- LOW STOCK -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-gray-500">
                Zems atlikums
            </p>

            <p class="mt-2 text-3xl font-bold text-orange-500">
                {{ $lowStockProducts }}
            </p>

            <a
                href="{{ route('products.index', ['stock' => 'low']) }}"
                class="mt-4 inline-block text-sm font-medium text-orange-600 hover:underline"
            >
                Skatīt preces →
            </a>

        </div>


        <!-- PENDING ORDERS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-gray-500">
                Gaida izsniegšanu
            </p>

            <p class="mt-2 text-3xl font-bold text-amber-500">
                {{ $pendingOrders }}
            </p>

            <a
                href="{{ route('customer-orders.index') }}"
                class="mt-4 inline-block text-sm font-medium text-amber-600 hover:underline"
            >
                Skatīt pasūtījumus →
            </a>

        </div>


        <!-- RECEIPTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-gray-500">
                Saņemšanas dokumenti
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-600">
                {{ $totalReceipts }}
            </p>

            <a
                href="{{ route('stock-receipts.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline"
            >
                Skatīt saņemšanu →
            </a>

        </div>


        <!-- INVENTORY ADJUSTMENTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm text-gray-500">
                Inventarizācijas korekcijas
            </p>

            <p class="mt-2 text-3xl font-bold text-purple-600">
                {{ $totalAdjustments }}
            </p>

            <a
                href="{{ route('inventory-adjustments.index') }}"
                class="mt-4 inline-block text-sm font-medium text-purple-600 hover:underline"
            >
                Skatīt inventarizāciju →
            </a>

        </div>

    </div>


    <!-- DASHBOARD CONTENT -->
    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

        <!-- LATEST RECEIPTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Jaunākās preču saņemšanas
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pēdējie noliktavā reģistrētie dokumenti
                    </p>

                </div>

                <a
                    href="{{ route('stock-receipts.index') }}"
                    class="text-sm font-medium text-blue-600 hover:underline"
                >
                    Skatīt visas
                </a>

            </div>


            @if($latestReceipts->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="border-b bg-gray-50">

                            <tr class="text-left text-sm text-gray-600">

                                <th class="p-4">
                                    Pavadzīmes Nr.
                                </th>

                                <th class="p-4">
                                    Daudzums
                                </th>

                                <th class="p-4">
                                    Datums
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($latestReceipts as $document)

                                <tr class="border-b last:border-b-0">

                                    <td class="p-4">

                                        <p class="font-semibold text-gray-800">
                                            {{ $document->document_number }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $document->user->name ?? '-' }}
                                        </p>

                                    </td>

                                    <td class="p-4 font-medium text-gray-800">
                                        {{ $document->receipts->sum('quantity') }} gab.
                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ $document->received_at->format('d.m.Y H:i') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="rounded-lg border border-dashed border-gray-300 p-10 text-center">

                    <p class="text-gray-500">
                        Preču saņemšana vēl nav reģistrēta.
                    </p>

                    <a
                        href="{{ route('stock-receipts.create') }}"
                        class="mt-4 inline-block font-medium text-blue-600 hover:underline"
                    >
                        Reģistrēt pirmo saņemšanu
                    </a>

                </div>

            @endif

        </div>


        <!-- RESTOCK PRODUCTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Nepieciešams papildināt
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Preces ar zemu noliktavas atlikumu
                    </p>

                </div>

                <a
                    href="{{ route('purchase-planning.index') }}"
                    class="text-sm font-medium text-blue-600 hover:underline"
                >
                    Iepirkumu plānošana
                </a>

            </div>


            @if($restockProducts->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="border-b bg-gray-50">

                            <tr class="text-left text-sm text-gray-600">

                                <th class="p-4">
                                    Prece
                                </th>

                                <th class="p-4">
                                    Atlikums
                                </th>

                                <th class="p-4">
                                    Minimums
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($restockProducts as $product)

                                <tr class="border-b last:border-b-0">

                                    <td class="p-4">

                                        <p class="font-semibold text-gray-800">
                                            {{ $product->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $product->category->name ?? '-' }}
                                        </p>

                                    </td>

                                    <td class="p-4">

                                        @if($product->quantity == 0)

                                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                                0 gab.
                                            </span>

                                        @else

                                            <span class="rounded-full bg-orange-100 px-3 py-1 text-sm font-semibold text-orange-700">
                                                {{ $product->quantity }} gab.
                                            </span>

                                        @endif

                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ $product->minimum_quantity }} gab.
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="rounded-lg border border-dashed border-gray-300 p-10 text-center">

                    <p class="font-medium text-green-600">
                        Visi preču atlikumi ir pietiekami.
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Pašlaik neviena prece nav jāpapildina.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <!-- QUICK ACTIONS -->
    <div class="mt-8 rounded-xl bg-white p-6 shadow-sm">

        <h3 class="text-lg font-semibold text-gray-800">
            Ātrās darbības
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Biežāk izmantotās noliktavas darbības
        </p>


        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

            <!-- ADMIN ONLY -->
            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('products.create') }}"
                    class="rounded-lg border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
                >

                    <p class="font-semibold text-gray-800">
                        + Pievienot preci
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Izveidot jaunu preci
                    </p>

                </a>

            @endif


            <!-- ORDERS -->
            <a
                href="{{ route('customer-orders.index') }}"
                class="rounded-lg border border-gray-200 p-4 transition hover:border-amber-300 hover:bg-amber-50"
            >

                <p class="font-semibold text-gray-800">
                    Pasūtījumi
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $pendingOrders }} gaida izsniegšanu
                </p>

            </a>


            <!-- RECEIPTS -->
            <a
                href="{{ route('stock-receipts.create') }}"
                class="rounded-lg border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
            >

                <p class="font-semibold text-gray-800">
                    + Reģistrēt saņemšanu
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Reģistrēt piegādātāja pavadzīmi
                </p>

            </a>


            <!-- INVENTORY -->
            <a
                href="{{ route('inventory-adjustments.create') }}"
                class="rounded-lg border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
            >

                <p class="font-semibold text-gray-800">
                    + Inventarizācija
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Reģistrēt atlikuma korekciju
                </p>

            </a>


            <!-- REPORTS -->
            <a
                href="{{ route('reports.index') }}"
                class="rounded-lg border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
            >

                <p class="font-semibold text-gray-800">
                    Atskaites
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Ģenerēt PDF vai Excel atskaiti
                </p>

            </a>

        </div>

    </div>

@endsection