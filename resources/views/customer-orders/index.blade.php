@extends('layouts.app')

@section('title', 'Pasūtījumi | StockManager')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- HEADER -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Pasūtījumu plūsma
                </span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Pasūtījumi
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Apskati klientu pasūtījumus un sagatavo tos izsniegšanai no noliktavas.
            </p>
        </div>

        <a
            href="{{ route('customer-orders.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300"
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

            Reģistrēt pasūtījumu
        </a>

    </div>


    <!-- SUCCESS -->
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">
            {{ session('success') }}
        </div>

    @endif


    <!-- ERRORS -->
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

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
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Kopā pasūtījumi
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                {{ $orders->count() }}
            </p>

        </div>


        <!-- PENDING -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Gaida izsniegšanu
            </p>

            <p class="mt-2 text-3xl font-bold text-amber-600 dark:text-amber-300">
                {{ $pendingCount }}
            </p>

        </div>


        <!-- ISSUED -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Izsniegti
            </p>

            <p class="mt-2 text-3xl font-bold text-emerald-600 dark:text-emerald-300">
                {{ $issuedCount }}
            </p>

        </div>

    </div>


    <!-- ORDERS -->
    <div class="space-y-5">

        @forelse ($orders as $order)

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

                <!-- ORDER HEADER -->
                <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex flex-wrap items-center gap-3">

                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ $order->order_number }}
                        </h2>


                        @if ($order->status === 'pending')

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Gaida izsniegšanu
                            </span>

                        @elseif ($order->status === 'issued')

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Izsniegts
                            </span>

                        @else

                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-white/[0.06] dark:text-slate-300">
                                {{ $order->status }}
                            </span>

                        @endif

                    </div>


                    <div class="text-sm text-slate-500 dark:text-slate-400">
                        {{ $order->ordered_at->format('d.m.Y H:i') }}
                    </div>

                </div>


                <!-- ORDER BODY -->
                <div class="p-6">

                    <!-- PRODUCTS -->
                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead>

                                <tr class="border-b border-slate-100 dark:border-emerald-400/10">

                                    <th class="pb-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Prece
                                    </th>

                                    <th class="pb-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Pasūtīts
                                    </th>

                                    <th class="pb-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Noliktavā
                                    </th>

                                    <th class="pb-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Pieejamība
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                                @foreach ($order->items as $item)

                                    @php
                                        $enoughStock =
                                            $item->product->quantity >= $item->quantity;
                                    @endphp

                                    <tr>

                                        <!-- PRODUCT -->
                                        <td class="py-4 pr-5">

                                            <p class="font-bold text-slate-900 dark:text-white">
                                                {{ $item->product->name }}
                                            </p>

                                            @if ($item->product->category)

                                                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                                    {{ $item->product->category->name }}
                                                </p>

                                            @endif

                                        </td>


                                        <!-- ORDER QUANTITY -->
                                        <td class="py-4 pr-5">

                                            <span class="font-bold text-slate-900 dark:text-white">
                                                {{ $item->quantity }} gab.
                                            </span>

                                        </td>


                                        <!-- CURRENT STOCK -->
                                        <td class="py-4 pr-5">

                                            <span class="text-slate-700 dark:text-slate-300">
                                                {{ $item->product->quantity }} gab.
                                            </span>

                                        </td>


                                        <!-- AVAILABILITY -->
                                        <td class="py-4">

                                            @if ($order->status === 'issued')

                                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-white/[0.06] dark:text-slate-300">
                                                    Izsniegts
                                                </span>

                                            @elseif ($enoughStock)

                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Pietiekams atlikums
                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 dark:bg-red-400/10 dark:text-red-300">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
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

                        <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                            <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                Piezīmes
                            </p>

                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
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


                        <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                @if ($canIssue)

                                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                                        Visas pasūtījuma preces ir pieejamas noliktavā.
                                    </p>

                                @else

                                    <p class="text-sm font-semibold text-red-600 dark:text-red-300">
                                        Pasūtījumu nevar izsniegt, jo visām precēm nepietiek atlikuma.
                                    </p>

                                @endif

                            </div>


                            <form
                                id="issue-form-{{ $order->id }}"
                                method="POST"
                                action="{{ route('customer-orders.issue', $order) }}"
                            >

                                @csrf

                                <button
                                    type="button"
                                    @disabled(!$canIssue)
                                    onclick="openIssueModal('issue-form-{{ $order->id }}')"
                                    class="rounded-lg px-5 py-3 text-sm font-semibold transition
                                    {{ $canIssue
                                        ? 'bg-emerald-400 text-[#07110f] hover:bg-emerald-300'
                                        : 'cursor-not-allowed bg-slate-300 text-slate-500 dark:bg-white/10 dark:text-slate-600' }}"
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
            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-50 text-2xl dark:bg-emerald-400/10">
                    📋
                </div>

                <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">
                    Nav reģistrētu pasūtījumu
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500 dark:text-slate-400">
                    Reģistrē pirmo interneta veikala pasūtījumu, lai tas parādītos noliktavas darbiniekiem.
                </p>

                <a
                    href="{{ route('customer-orders.create') }}"
                    class="mt-6 inline-flex rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300"
                >
                    Reģistrēt pirmo pasūtījumu
                </a>

            </div>

        @endforelse

    </div>

</div>


<!-- ISSUE CONFIRMATION MODAL -->
<div
    id="issue-modal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4 backdrop-blur-sm"
>
    <div
        class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl
               dark:border-emerald-400/20 dark:bg-[#0d1b18]"
    >

        <div class="flex items-start gap-4">

            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl
                       bg-emerald-100 text-emerald-600
                       dark:bg-emerald-400/10 dark:text-emerald-300"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>


            <div>

                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    Izsniegt pasūtījumu?
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Vai tiešām vēlaties izsniegt šo pasūtījumu?
                </p>

            </div>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <button
                type="button"
                onclick="closeIssueModal()"
                class="rounded-xl border border-slate-200 px-5 py-2.5
                       text-sm font-semibold text-slate-700 transition
                       hover:bg-slate-100
                       dark:border-white/10 dark:text-slate-300
                       dark:hover:bg-white/5"
            >
                Nē
            </button>


            <button
                type="button"
                onclick="confirmIssue()"
                class="rounded-xl bg-emerald-400 px-5 py-2.5
                       text-sm font-bold text-[#07110f] transition
                       hover:bg-emerald-300"
            >
                Jā, izsniegt
            </button>

        </div>

    </div>
</div>


<script>
    let selectedIssueForm = null;

    function openIssueModal(formId) {
        selectedIssueForm = document.getElementById(formId);

        const modal = document.getElementById('issue-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeIssueModal() {
        const modal = document.getElementById('issue-modal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        selectedIssueForm = null;
    }


    function confirmIssue() {
        if (!selectedIssueForm) {
            return;
        }

        const form = selectedIssueForm;

        closeIssueModal();

        form.submit();
    }


    document
        .getElementById('issue-modal')
        .addEventListener('click', function (event) {

            if (event.target === this) {
                closeIssueModal();
            }

        });


    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeIssueModal();
        }

    });
</script>

@endsection