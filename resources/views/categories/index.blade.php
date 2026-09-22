@extends('layouts.app')

@section('title', 'Kategorijas | StockManager')
@section('page-title', 'Kategorijas')

@section('content')

<!-- HEADER -->
<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

    <div>

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Preču organizācija
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Kategorijas
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Pārvaldi preču kategorijas un to hierarhisko struktūru.
        </p>

    </div>


    <a
        href="{{ route('categories.create') }}"
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

        Pievienot kategoriju

    </a>

</div>


<!-- SUCCESS -->
@if(session('success'))

    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">

        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-400/15">

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


<!-- ERROR -->
@if(session('error'))

    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-400/10">

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v4"/>
                <path d="M12 16h.01"/>
            </svg>

        </div>

        {{ session('error') }}

    </div>

@endif


<!-- CATEGORY TABLE -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

    <!-- TABLE HEADER -->
    <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="font-bold text-slate-900 dark:text-white">
                Kategoriju struktūra
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Galvenās kategorijas un tām piesaistītās apakškategorijas
            </p>

        </div>

        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 dark:bg-white/[0.05] dark:text-slate-300">

            <svg
                class="h-3.5 w-3.5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M4 6h16"/>
                <path d="M4 12h16"/>
                <path d="M4 18h16"/>
            </svg>

            {{ $categories->count() }} kategorijas

        </span>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">

                    <th class="px-6 py-3">
                        Kategorija
                    </th>

                    <th class="px-6 py-3">
                        Vecākkategorija
                    </th>

                    <th class="px-6 py-3">
                        Apraksts
                    </th>

                    <th class="px-6 py-3">
                        Preces
                    </th>

                    <th class="px-6 py-3">
                        Apakškategorijas
                    </th>

                    <th class="px-6 py-3 text-right">
                        Darbības
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                @forelse($categories as $category)

                    @php
                        $level = 0;
                        $currentParent = $category->parent;

                        while ($currentParent) {
                            $level++;
                            $currentParent = $currentParent->parent;
                        }
                    @endphp


                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                        <!-- CATEGORY -->
                        <td class="px-6 py-5">

                            <div
                                class="flex items-center"
                                style="padding-left: {{ $level * 28 }}px;"
                            >

                                @if($level > 0)

                                    <div class="mr-3 flex items-center text-slate-300 dark:text-emerald-400/30">

                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M6 4v7a3 3 0 0 0 3 3h9"/>
                                            <path d="m15 11 3 3-3 3"/>
                                        </svg>

                                    </div>

                                @endif


                                <div class="flex items-center gap-3">

                                    <!-- ICON -->
                                    <div class="
                                        flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                        {{ $level === 0
                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300'
                                            : 'bg-slate-100 text-slate-500 dark:bg-white/[0.05] dark:text-slate-400'
                                        }}
                                    ">

                                        @if($level === 0)

                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path d="M3 7h6l2 2h10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>
                                                <path d="M3 7V5a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v2"/>
                                            </svg>

                                        @else

                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path d="M4 6h16"/>
                                                <path d="M4 12h16"/>
                                                <path d="M4 18h10"/>
                                            </svg>

                                        @endif

                                    </div>


                                    <div>

                                        <p class="font-bold text-slate-900 dark:text-white">
                                            {{ $category->name }}
                                        </p>


                                        @if($level === 0)

                                            <span class="mt-1.5 inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                                Galvenā kategorija
                                            </span>

                                        @else

                                            <span class="mt-1.5 inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] text-slate-500 dark:bg-white/[0.05] dark:text-slate-400">
                                                {{ $level }}. līmenis
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </td>


                        <!-- PARENT -->
                        <td class="px-6 py-5">

                            @if($category->parent)

                                <div class="inline-flex items-center gap-2">

                                    <svg
                                        class="h-3.5 w-3.5 text-slate-400 dark:text-slate-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M3 7h6l2 2h10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>
                                    </svg>

                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $category->parent->name }}
                                    </span>

                                </div>

                            @else

                                <span class="text-slate-300 dark:text-slate-600">
                                    —
                                </span>

                            @endif

                        </td>


                        <!-- DESCRIPTION -->
                        <td class="max-w-xs px-6 py-5">

                            @if($category->description)

                                <p class="text-sm leading-5 text-slate-500 dark:text-slate-400">
                                    {{ $category->description }}
                                </p>

                            @else

                                <span class="text-sm text-slate-400 dark:text-slate-500">
                                    Nav apraksta
                                </span>

                            @endif

                        </td>


                        <!-- PRODUCT COUNT -->
                        <td class="px-6 py-5">

                            <span class="inline-flex min-w-10 items-center justify-center rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                {{ $category->products_count }}
                            </span>

                        </td>


                        <!-- CHILD COUNT -->
                        <td class="px-6 py-5">

                            @if($category->children_count > 0)

                                <span class="inline-flex min-w-10 items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 dark:bg-white/[0.06] dark:text-slate-300">
                                    {{ $category->children_count }}
                                </span>

                            @else

                                <span class="inline-flex min-w-10 items-center justify-center rounded-lg bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-400 dark:bg-white/[0.025] dark:text-slate-600">
                                    0
                                </span>

                            @endif

                        </td>


                        <!-- ACTIONS -->
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-end gap-2">

                                <a
                                    href="{{ route('categories.edit', $category) }}"
                                    title="Rediģēt"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-400 dark:hover:border-emerald-400/30 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                                >

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                    </svg>

                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('categories.destroy', $category) }}"
                                    onsubmit="return confirm('Vai tiešām vēlies dzēst kategoriju {{ $category->name }}?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Dzēst"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v5"/>
                                            <path d="M14 11v5"/>
                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <!-- EMPTY STATE -->
                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-16 text-center"
                        >

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                                <svg
                                    class="h-7 w-7"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >
                                    <path d="M3 7h6l2 2h10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>
                                    <path d="M12 13v4"/>
                                    <path d="M10 15h4"/>
                                </svg>

                            </div>

                            <h3 class="mt-5 font-bold text-slate-800 dark:text-slate-200">
                                Nav izveidota neviena kategorija
                            </h3>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Izveido pirmo kategoriju preču organizēšanai.
                            </p>

                            <a
                                href="{{ route('categories.create') }}"
                                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300"
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

                                Pievienot kategoriju

                            </a>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection