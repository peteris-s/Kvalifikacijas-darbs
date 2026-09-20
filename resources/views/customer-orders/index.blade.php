@extends('layouts.app')

@section('title', 'Pasūtījumi | StockManager')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- HEADER -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Pasūtījumi
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Apskati klientu pasūtījumus un sagatavo tos izsniegšanai no noliktavas.
            </p>
        </div>

        <a
            href="{{ route('customer-orders.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
        >
            + Reģistrēt pasūtījumu
        </a>

    </div>


    <!-- SUCCESS -->
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <!-- ERRORS -->
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

            <p class="font-semibold">
                Darbību neizdevās izpildīt.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <!-- STATISTICS -->
    @php
        $pendingCount = $orders
            ->where('status', 'pending')
            ->count();

        $issuedCount = $orders
            ->where('status', 'issued')
            ->count();
    @endphp

    <div class="mb-8 grid gap-5 md:grid-cols-3">

        <!-- TOTAL -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Kopā pasūtījumi
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900">
                {{ $orders->count() }}
            </p>

        </div>


        <!-- PENDING -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Gaida izsniegšanu
            </p>

            <p class="mt-2 text-3xl font-bold text-amber-600">
                {{ $pendingCount }}
            </p>

        </div>


        <!-- ISSUED -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Izsniegti
            </p>

            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ $issuedCount }}
            </p>

        </div>

    </div>


    <!-- ORDERS -->
    <div class="space-y-5">

        @forelse ($orders as $order)

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <!-- ORDER HEADER -->
                <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex flex-wrap items-center gap-3">

                        <h2 class="text-lg font-bold text-gray-900">
                            {{ $order->order_number }}
                        </h2>


                        @if ($order->status === 'pending')

                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Gaida izsniegšanu
                            </span>

                        @elseif ($order->status === 'issued')

                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Izsniegts
                            </span>

                        @else

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                {{ $order->status }}
                            </span>

                        @endif

                    </div>


                    <div class="text-sm text-gray-500">

                        {{ $order->ordered_at->format('d.m.Y H:i') }}

                    </div>

                </div>


                <!-- ORDER BODY -->
                <div class="p-6">

                    <!-- PRODUCTS -->
                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead>

                                <tr class="border-b border-gray-100">

                                    <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Prece
                                    </th>

                                    <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Pasūtīts
                                    </th>

                                    <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Noliktavā
                                    </th>

                                    <th class="pb-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Pieejamība
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach ($order->items as $item)

                                    @php
                                        $enoughStock =
                                            $item->product->quantity >= $item->quantity;
                                    @endphp

                                    <tr>

                                        <!-- PRODUCT -->
                                        <td class="py-4 pr-5">

                                            <p class="font-semibold text-gray-900">
                                                {{ $item->product->name }}
                                            </p>

                                            @if ($item->product->category)

                                                <p class="mt-1 text-xs text-gray-400">
                                                    {{ $item->product->category->name }}
                                                </p>

                                            @endif

                                        </td>


                                        <!-- ORDER QUANTITY -->
                                        <td class="py-4 pr-5">

                                            <span class="font-semibold text-gray-900">
                                                {{ $item->quantity }} gab.
                                            </span>

                                        </td>


                                        <!-- CURRENT STOCK -->
                                        <td class="py-4 pr-5">

                                            <span class="text-gray-700">
                                                {{ $item->product->quantity }} gab.
                                            </span>

                                        </td>


                                        <!-- AVAILABILITY -->
                                        <td class="py-4">

                                            @if ($order->status === 'issued')

                                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                    Izsniegts
                                                </span>

                                            @elseif ($enoughStock)

                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Pietiekams atlikums
                                                </span>

                                            @else

                                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    Nepietiek atlikuma
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <!-- NOTES -->
                    @if ($order->notes)

                        <div class="mt-5 rounded-lg bg-gray-50 px-4 py-3">

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Piezīmes
                            </p>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $order->notes }}
                            </p>

                        </div>

                    @endif


                    <!-- ACTION -->
                    @if ($order->status === 'pending')

                        @php
                            $canIssue = true;

                            foreach ($order->items as $item) {
                                if ($item->product->quantity < $item->quantity) {
                                    $canIssue = false;
                                    break;
                                }
                            }
                        @endphp


                        <div class="mt-6 flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                @if ($canIssue)

                                    <p class="text-sm font-medium text-green-700">
                                        Visas pasūtījuma preces ir pieejamas noliktavā.
                                    </p>

                                @else

                                    <p class="text-sm font-medium text-red-600">
                                        Pasūtījumu nevar izsniegt, jo visām precēm nepietiek atlikuma.
                                    </p>

                                @endif

                            </div>


                            <form
                                method="POST"
                                action="{{ route('customer-orders.issue', $order) }}"
                                onsubmit="return confirm('Vai tiešām izsniegt visu pasūtījumu {{ $order->order_number }}?');"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    @disabled(!$canIssue)
                                    class="rounded-lg px-5 py-3 text-sm font-semibold text-white transition
                                    {{ $canIssue
                                        ? 'bg-blue-600 hover:bg-blue-700'
                                        : 'cursor-not-allowed bg-gray-300' }}"
                                >
                                    Izsniegt pasūtījumu
                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            </div>

        @empty

            <!-- EMPTY -->
            <div class="rounded-xl bg-white px-6 py-16 text-center shadow-sm">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 text-2xl">
                    📋
                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-900">
                    Nav reģistrētu pasūtījumu
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                    Reģistrē pirmo interneta veikala pasūtījumu, lai tas parādītos noliktavas darbiniekiem.
                </p>

                <a
                    href="{{ route('customer-orders.create') }}"
                    class="mt-6 inline-flex rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Reģistrēt pirmo pasūtījumu
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection