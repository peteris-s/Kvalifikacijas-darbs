
@extends('layouts.app')

@section('title', 'Preču izsniegšana | StockManager')
@section('page-title', 'Preču izsniegšana')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Noliktavas kustība
                </span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Preču izsniegšana
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Reģistrē un apskati no noliktavas izsniegtās preces.
            </p>
        </div>

        <a href="{{ route('stock-issues.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>
            Reģistrēt izsniegšanu
        </a>
    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-400/15">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="m5 12 4 4L19 6"/>
                </svg>
            </div>
            {{ session('success') }}
        </div>
    @endif

    {{-- STATISTICS --}}
    <div class="mb-6 grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Pasūtījumi
                    </p>
                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $totalOrders }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M6 2h12v20l-6-4-6 4Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Preču pozīcijas
                    </p>
                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $totalPositions }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="m21 8-9 5-9-5"/>
                        <path d="m3 8 9-5 9 5v8l-9 5-9-5Z"/>
                        <path d="M12 13v8"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Izsniegti gabali
                    </p>
                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $totalItems }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-500 dark:bg-red-400/10 dark:text-red-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3v12"/>
                        <path d="m7 10 5 5 5-5"/>
                        <path d="M5 21h14"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- HISTORY --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-slate-900 dark:text-white">
                    Izsniegtie pasūtījumi
                </h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Nospied uz pasūtījuma, lai apskatītu tā preces
                </p>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                {{ $totalOrders }} pasūtījumi
            </div>
        </div>

        @forelse ($groupedIssues as $orderNumber => $issues)
            @php
                $firstIssue = $issues->first();
                $productTypes = $issues->count();
                $orderQuantity = $issues->sum('quantity');
                $dropdownId = 'order-' . $loop->index;
            @endphp

            <div class="border-b border-slate-100 last:border-b-0 dark:border-emerald-400/10">

                {{-- ORDER SUMMARY --}}
                <button type="button"
                        class="order-toggle grid w-full grid-cols-1 gap-5 px-6 py-5 text-left transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04] md:grid-cols-[180px_1fr_180px_180px_44px] md:items-center"
                        data-target="{{ $dropdownId }}"
                        aria-controls="{{ $dropdownId }}"
                        aria-expanded="false">

                    <div>
                        <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 md:hidden">
                            Pasūtījums
                        </p>

                        <span class="inline-flex max-w-full items-center gap-2 break-all rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2h12v20l-6-4-6 4Z"/>
                            </svg>
                            {{ $orderNumber }}
                        </span>
                    </div>

                    <div>
                        <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 md:hidden">
                            Preces
                        </p>

                        <p class="font-bold text-slate-900 dark:text-white">
                            {{ $productTypes }}
                            {{ $productTypes === 1 ? 'prece' : 'preces' }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                            Kopā {{ $orderQuantity }} gab.
                        </p>
                    </div>

                    <div>
                        <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 md:hidden">
                            Izsniedza
                        </p>

                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold uppercase text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                {{ mb_substr($firstIssue->user->name ?? '?', 0, 1) }}
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $firstIssue->user->name ?? 'Nav zināms' }}
                                </p>

                                @if ($firstIssue->user)
                                    <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                        {{ $firstIssue->user->isAdmin() ? 'Administrators' : 'Darbinieks' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 md:hidden">
                            Datums
                        </p>

                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                            <div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $firstIssue->issued_at->format('d.m.Y') }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                    {{ $firstIssue->issued_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-400 transition dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-500">
                            <svg class="order-chevron h-4 w-4 transition-transform duration-200"
                                 viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </div>
                    </div>

                </button>

                {{-- EXPANDED DETAILS --}}
                <div id="{{ $dropdownId }}"
                     class="order-details hidden border-t border-slate-100 bg-slate-50/60 dark:border-emerald-400/10 dark:bg-[#091512]">

                    <div class="px-6 py-6">

                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white">
                                    Pasūtījuma saturs
                                </p>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $orderNumber }} · {{ $productTypes }} preču pozīcijas
                                </p>
                            </div>

                            <div class="inline-flex w-fit items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600 dark:bg-red-400/10 dark:text-red-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                -{{ $orderQuantity }} gab. kopā
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-emerald-400/10 dark:bg-[#0d1b18]">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">
                                        <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                            <th class="px-5 py-3">Prece</th>
                                            <th class="px-5 py-3">Kategorija</th>
                                            <th class="px-5 py-3">Daudzums</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">
                                        @foreach ($issues as $issue)
                                            <tr>
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">
                                                            <svg class="h-4 w-4" viewBox="0 0 24 24"
                                                                 fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="m21 8-9 5-9-5"/>
                                                                <path d="m3 8 9-5 9 5v8l-9 5-9-5Z"/>
                                                                <path d="M12 13v8"/>
                                                            </svg>
                                                        </div>

                                                        <p class="font-bold text-slate-900 dark:text-white">
                                                            {{ $issue->product->name ?? 'Dzēsta prece' }}
                                                        </p>
                                                    </div>
                                                </td>

                                                <td class="px-5 py-4">
                                                    @if ($issue->product?->category)
                                                        <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-white/[0.05] dark:text-slate-400">
                                                            {{ $issue->product->category->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-xs text-slate-400 dark:text-slate-600">
                                                            Nav kategorijas
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="whitespace-nowrap px-5 py-4">
                                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600 dark:bg-red-400/10 dark:text-red-300">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                        -{{ $issue->quantity }} gab.
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- NOTES --}}
                        <div class="mt-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">
                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-white/[0.05] dark:text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 4h16v13H8l-4 4Z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.08em] text-slate-400 dark:text-slate-500">
                                        Piezīmes
                                    </p>

                                    @if ($firstIssue->notes)
                                        <p class="mt-1.5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                            {{ $firstIssue->notes }}
                                        </p>
                                    @else
                                        <p class="mt-1.5 text-sm text-slate-400 dark:text-slate-500">
                                            Šim pasūtījumam nav pievienotu piezīmju.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        @empty

            {{-- EMPTY STATE --}}
            <div class="px-6 py-16 text-center">
                <div class="mx-auto max-w-md">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 dark:bg-emerald-400/10 dark:text-emerald-300">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 font-bold text-slate-900 dark:text-white">
                        Nav reģistrētu izsniegšanu
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Kad no noliktavas tiks izsniegtas preces, informācija parādīsies šeit.
                    </p>

                    <a href="{{ route('stock-issues.create') }}"
                       class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300">
                        <svg class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>
                        Reģistrēt pirmo izsniegšanu
                    </a>
                </div>
            </div>

        @endforelse

    </div>

    {{-- CUSTOM PAGINATION --}}
    @if ($orderPages->total() > 0)
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-5 py-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                {{-- RESULTS INFO --}}
                <div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                        Rāda
                        <span class="font-bold text-emerald-600 dark:text-emerald-300">
                            {{ $orderPages->firstItem() }}–{{ $orderPages->lastItem() }}
                        </span>
                        no
                        <span class="font-bold text-emerald-600 dark:text-emerald-300">
                            {{ $orderPages->total() }}
                        </span>
                        pasūtījumiem
                    </p>

                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                        Lapa {{ $orderPages->currentPage() }} no {{ $orderPages->lastPage() }}
                        · {{ $orderPages->perPage() }} ieraksti vienā lapā
                    </p>
                </div>

                {{-- PAGINATION CONTROLS --}}
                @if ($orderPages->hasPages())
                    <nav class="flex flex-wrap items-center gap-2"
                         aria-label="Izsniegšanas vēstures lapošana">

                        {{-- PREVIOUS --}}
                        @if ($orderPages->onFirstPage())
                            <span class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 opacity-60 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-600">
                                <span aria-hidden="true">←</span>
                                Iepriekšējā
                            </span>
                        @else
                            <a href="{{ $orderPages->previousPageUrl() }}"
                               rel="prev"
                               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#091512] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">
                                <span aria-hidden="true">←</span>
                                Iepriekšējā
                            </a>
                        @endif

                        {{-- PAGE NUMBERS --}}
                        @foreach ($orderPages->getUrlRange(
                            max(1, $orderPages->currentPage() - 2),
                            min($orderPages->lastPage(), $orderPages->currentPage() + 2)
                        ) as $page => $url)

                            @if ($page == $orderPages->currentPage())
                                <span aria-current="page"
                                      class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl bg-emerald-400 px-3 text-sm font-bold text-[#07110f] shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   aria-label="Atvērt {{ $page }}. lapu"
                                   class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-600 transition hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#091512] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">
                                    {{ $page }}
                                </a>
                            @endif

                        @endforeach

                        {{-- NEXT --}}
                        @if ($orderPages->hasMorePages())
                            <a href="{{ $orderPages->nextPageUrl() }}"
                               rel="next"
                               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#091512] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">
                                Nākamā
                                <span aria-hidden="true">→</span>
                            </a>
                        @else
                            <span class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 opacity-60 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-600">
                                Nākamā
                                <span aria-hidden="true">→</span>
                            </span>
                        @endif

                    </nav>
                @endif

            </div>

        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.order-toggle');

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetId = toggle.dataset.target;
            const details = document.getElementById(targetId);
            const chevron = toggle.querySelector('.order-chevron');

            if (!details) {
                return;
            }

            const isOpen = !details.classList.contains('hidden');

            if (isOpen) {
                details.classList.add('hidden');

                if (chevron) {
                    chevron.classList.remove('rotate-180');
                }

                toggle.setAttribute('aria-expanded', 'false');
            } else {
                details.classList.remove('hidden');

                if (chevron) {
                    chevron.classList.add('rotate-180');
                }

                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>

@endsection
