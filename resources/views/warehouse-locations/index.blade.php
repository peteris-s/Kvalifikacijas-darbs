@extends('layouts.app')

@section('title', 'Noliktavas struktūra | StockManager')
@section('page-title', 'Noliktavas struktūra')

@section('content')

<!-- HEADER -->
<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

    <div>

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Noliktavas organizācija
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Noliktavas struktūra
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Pārvaldi noliktavas zonas un tajās esošos plauktus.
        </p>

    </div>


    <a
        href="{{ route('warehouse-locations.create') }}"
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

        Pievienot vietu

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


@if($locations->isEmpty())

    <!-- EMPTY STATE -->
    <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

            <svg
                class="h-7 w-7"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.7"
            >
                <path d="M3 21h18"/>
                <path d="M5 21V7l7-4 7 4v14"/>
                <path d="M9 21v-5h6v5"/>
                <path d="M8 10h.01"/>
                <path d="M12 10h.01"/>
                <path d="M16 10h.01"/>
            </svg>

        </div>

        <h2 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">
            Noliktavas struktūra vēl nav izveidota
        </h2>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Izveido pirmo noliktavas zonu un pēc tam pievieno tai plauktus.
        </p>

        <a
            href="{{ route('warehouse-locations.create') }}"
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

            Izveidot pirmo zonu

        </a>

    </div>

@else

    <!-- STRUCTURE -->
    <div class="space-y-6">

        @foreach($locations as $location)

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

                <!-- ZONE HEADER -->
                <div class="border-b border-slate-100 bg-slate-50/70 p-6 dark:border-emerald-400/10 dark:bg-emerald-400/[0.035]">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                        <!-- ZONE INFORMATION -->
                        <div>

                            <div class="flex items-center gap-4">

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">

                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="M3 21h18"/>
                                        <path d="M5 21V7l7-4 7 4v14"/>
                                        <path d="M9 21v-5h6v5"/>
                                    </svg>

                                </div>

                                <div>

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                                            {{ $location->name }}
                                        </h2>

                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                            Zona
                                        </span>

                                    </div>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $location->children->count() }}
                                        {{ $location->children->count() === 1 ? 'plaukts' : 'plaukti' }}
                                    </p>

                                </div>

                            </div>


                            @if($location->description)

                                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                                    {{ $location->description }}
                                </p>

                            @endif

                        </div>


                        <!-- ZONE ACTIONS -->
                        <div class="flex shrink-0 items-center gap-2">

                            <a
                                href="{{ route('warehouse-locations.edit', $location) }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-bold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#091512] dark:text-slate-300 dark:hover:border-emerald-400/30 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                            >

                                <svg
                                    class="h-3.5 w-3.5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                </svg>

                                Rediģēt

                            </a>


                            <form
                                method="POST"
                                action="{{ route('warehouse-locations.destroy', $location) }}"
                                onsubmit="return confirm('Vai tiešām vēlies dzēst šo zonu?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-3.5 py-2.5 text-xs font-bold text-red-700 transition hover:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15"
                                >

                                    <svg
                                        class="h-3.5 w-3.5"
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

                                    Dzēst

                                </button>

                            </form>

                        </div>

                    </div>

                </div>


                <!-- SHELVES -->
                <div class="p-6">

                    <div class="mb-5 flex items-center justify-between">

                        <div>

                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                Plaukti
                            </p>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Šajā zonā esošās preču glabāšanas vietas
                            </p>

                        </div>

                        <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 dark:bg-white/[0.05] dark:text-slate-300">
                            {{ $location->children->count() }}
                        </span>

                    </div>


                    @if($location->children->count() > 0)

                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                            @foreach($location->children as $child)

                                <div class="group rounded-xl border border-slate-200 bg-slate-50/40 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/40 dark:border-emerald-400/10 dark:bg-[#091512] dark:hover:border-emerald-400/25 dark:hover:bg-emerald-400/[0.04]">

                                    <div class="flex items-start justify-between gap-3">

                                        <!-- SHELF -->
                                        <div class="min-w-0">

                                            <div class="flex items-center gap-3">

                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm ring-1 ring-slate-200 transition group-hover:text-emerald-600 dark:bg-emerald-400/[0.06] dark:text-slate-400 dark:ring-emerald-400/10 dark:group-hover:text-emerald-300">

                                                    <svg
                                                        class="h-4 w-4"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path d="M4 4h16"/>
                                                        <path d="M4 10h16"/>
                                                        <path d="M4 16h16"/>
                                                        <path d="M6 4v16"/>
                                                        <path d="M18 4v16"/>
                                                    </svg>

                                                </div>

                                                <div class="min-w-0">

                                                    <p class="truncate font-bold text-slate-800 dark:text-slate-200">
                                                        {{ $child->name }}
                                                    </p>

                                                    <p class="mt-0.5 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                                                        Plaukts
                                                    </p>

                                                </div>

                                            </div>


                                            @if($child->description)

                                                <p class="mt-3 text-sm leading-5 text-slate-500 dark:text-slate-400">
                                                    {{ $child->description }}
                                                </p>

                                            @endif

                                        </div>


                                        <!-- SHELF ACTIONS -->
                                        <div class="flex shrink-0 items-center gap-1">

                                            <a
                                                href="{{ route('warehouse-locations.edit', $child) }}"
                                                title="Rediģēt"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-emerald-100 hover:text-emerald-700 dark:text-slate-500 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                                            >

                                                <svg
                                                    class="h-3.5 w-3.5"
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
                                                action="{{ route('warehouse-locations.destroy', $child) }}"
                                                onsubmit="return confirm('Vai tiešām vēlies dzēst šo plauktu?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    title="Dzēst"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-100 hover:text-red-700 dark:text-slate-500 dark:hover:bg-red-400/10 dark:hover:text-red-300"
                                                >

                                                    <svg
                                                        class="h-3.5 w-3.5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path d="M3 6h18"/>
                                                        <path d="M8 6V4h8v2"/>
                                                        <path d="M19 6l-1 14H6L5 6"/>
                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <!-- NO SHELVES -->
                        <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/50 px-5 py-8 text-center dark:border-emerald-400/10 dark:bg-emerald-400/[0.02]">

                            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-400 dark:bg-white/[0.04] dark:text-slate-500">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M4 4h16"/>
                                    <path d="M4 10h16"/>
                                    <path d="M4 16h16"/>
                                    <path d="M6 4v16"/>
                                    <path d="M18 4v16"/>
                                </svg>

                            </div>

                            <p class="mt-3 text-sm font-semibold text-slate-600 dark:text-slate-300">
                                Šajā zonā vēl nav plauktu
                            </p>

                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                Pievieno jaunu vietu un izvēlies šo zonu kā vecāku.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection