@extends('layouts.app')

@section('title', 'Preču saņemšana | StockManager')
@section('page-title', 'Preču saņemšana')

@section('content')

    <!-- HEADER -->
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Noliktavas papildināšana
                </span>

            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Preču saņemšana
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Saņemto preču pavadzīmes un to vēsture
            </p>

        </div>


        <a
            href="{{ route('stock-receipts.create') }}"
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

            Reģistrēt saņemšanu

        </a>

    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">

            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-400/15 dark:text-emerald-300">

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m5 12 4 4L19 6"/>
                </svg>

            </div>

            {{ session('success') }}

        </div>

    @endif


    <!-- RECEIPTS TABLE -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <!-- TABLE HEADER -->
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

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

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Saņemšanas vēsture
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Visas noliktavā reģistrētās preču saņemšanas
                    </p>

                </div>

            </div>


            <span class="hidden rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500 dark:bg-emerald-400/10 dark:text-emerald-300 sm:inline-flex">
                {{ $documents->count() }} dokumenti
            </span>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                    <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">

                        <th class="px-6 py-3">
                            Pavadzīmes Nr.
                        </th>

                        <th class="px-6 py-3">
                            Preces
                        </th>

                        <th class="px-6 py-3">
                            Kopējais daudzums
                        </th>

                        <th class="px-6 py-3">
                            Saņemšanas datums
                        </th>

                        <th class="px-6 py-3">
                            Reģistrēja
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                    @forelse($documents as $document)

                        <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                            <!-- DOCUMENT NUMBER -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-emerald-400/10 dark:text-emerald-300">

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

                                    <span class="font-bold text-slate-900 dark:text-white">
                                        {{ $document->document_number }}
                                    </span>

                                </div>

                            </td>


                            <!-- PRODUCTS -->
                            <td class="px-6 py-5">

                                <div class="space-y-2">

                                    @foreach($document->receipts as $receipt)

                                        <div class="flex flex-wrap items-center gap-2">

                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                                {{ $receipt->product->name ?? 'Dzēsta prece' }}
                                            </span>

                                            <span class="inline-flex items-center rounded-lg bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                                +{{ $receipt->quantity }}
                                            </span>

                                        </div>

                                    @endforeach

                                </div>

                            </td>


                            <!-- TOTAL QUANTITY -->
                            <td class="px-6 py-5">

                                <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 dark:bg-emerald-400/10 dark:text-emerald-200">

                                    {{ $document->receipts->sum('quantity') }}

                                    <span class="font-medium text-slate-400 dark:text-emerald-300/60">
                                        gab.
                                    </span>

                                </span>

                            </td>


                            <!-- DATE -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">

                                    <svg
                                        class="h-4 w-4 text-slate-400 dark:text-slate-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>

                                    {{ $document->received_at->format('d.m.Y H:i') }}

                                </div>

                            </td>


                            <!-- USER -->
                            <td class="px-6 py-5">

                                <div class="inline-flex items-center gap-2">

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

                        <!-- EMPTY STATE -->
                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 dark:bg-emerald-400/10 dark:text-emerald-300">

                                    <svg
                                        class="h-6 w-6"
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

                                <p class="mt-4 font-bold text-slate-700 dark:text-slate-200">
                                    Pavadzīmes vēl nav reģistrētas
                                </p>

                                <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
                                    Reģistrē pirmo preču saņemšanu.
                                </p>

                                <a
                                    href="{{ route('stock-receipts.create') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300"
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

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection