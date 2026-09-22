@extends('layouts.app')

@section('title', 'Inventarizācija | StockManager')
@section('page-title', 'Inventarizācija')

@section('content')

<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

    <div>

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Noliktavas kontrole
            </span>
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Inventarizācija
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Inventarizācijas starpību un atlikumu korekciju vēsture
        </p>

    </div>

    <a
        href="{{ route('inventory-adjustments.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300">

        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14"/>
            <path d="M5 12h14"/>
        </svg>

        Jauna inventarizācija
    </a>

</div>


@if(session('success'))

<div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">

    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-400/15">

        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m5 12 4 4L19 6"/>
        </svg>

    </div>

    {{ session('success') }}

</div>

@endif


<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

        <div>

            <h2 class="font-bold text-slate-900 dark:text-white">
                Inventarizācijas vēsture
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Visi atlikumu korekciju ieraksti
            </p>

        </div>

        <span class="hidden rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300 sm:inline-flex">
            {{ $adjustments->count() }} ieraksti
        </span>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">

                    <th class="px-6 py-3">Prece</th>
                    <th class="px-6 py-3">Sistēmā</th>
                    <th class="px-6 py-3">Faktiski</th>
                    <th class="px-6 py-3">Starpība</th>
                    <th class="px-6 py-3">Iemesls</th>
                    <th class="px-6 py-3">Datums</th>
                    <th class="px-6 py-3">Veica</th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                @forelse($adjustments as $adjustment)

                <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                    <td class="px-6 py-5">

                        <p class="font-bold text-slate-900 dark:text-white">
                            {{ $adjustment->product->name ?? 'Dzēsta prece' }}
                        </p>

                    </td>


                    <td class="px-6 py-5">

                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">
                            {{ $adjustment->system_quantity }} gab.
                        </span>

                    </td>


                    <td class="px-6 py-5">

                        <span class="font-semibold text-slate-900 dark:text-white">
                            {{ $adjustment->actual_quantity }} gab.
                        </span>

                    </td>


                    <td class="px-6 py-5">

                        @if($adjustment->difference > 0)

                        <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            +{{ $adjustment->difference }}
                        </span>

                        @elseif($adjustment->difference < 0)

                        <span class="inline-flex items-center gap-1 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 dark:bg-red-400/10 dark:text-red-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            {{ $adjustment->difference }}
                        </span>

                        @else

                        <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 dark:bg-white/10 dark:text-slate-300">
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


                    <td class="px-6 py-5">

                        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">

                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                            {{ $adjustment->adjusted_at->format('d.m.Y H:i') }}

                        </div>

                    </td>


                    <td class="px-6 py-5">

                        <div class="inline-flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold uppercase text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                {{ mb_substr($adjustment->user->name ?? '?',0,1) }}
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

                        <div class="mx-auto max-w-md">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 dark:bg-emerald-400/10 dark:text-emerald-300">

                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M4 7h16"/>
                                    <path d="M7 3v4"/>
                                    <path d="M17 3v4"/>
                                    <rect x="4" y="7" width="16" height="13" rx="2"/>
                                </svg>

                            </div>

                            <h3 class="mt-4 font-bold text-slate-900 dark:text-white">
                                Inventarizācijas ierakstu vēl nav
                            </h3>

                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                Veic pirmo noliktavas inventarizāciju.
                            </p>

                            <a
                                href="{{ route('inventory-adjustments.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300">

                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14"/>
                                    <path d="M5 12h14"/>
                                </svg>

                                Jauna inventarizācija
                            </a>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection