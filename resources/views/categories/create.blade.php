@extends('layouts.app')

@section('title', 'Pievienot kategoriju | StockManager')
@section('page-title', 'Pievienot kategoriju')

@section('content')

<div class="mx-auto max-w-3xl">

    <!-- BACK -->
    <a
        href="{{ route('categories.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-300"
    >
        <svg
            class="h-4 w-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <path d="m15 18-6-6 6-6"/>
        </svg>

        Atpakaļ uz kategorijām
    </a>


    <!-- HEADER -->
    <div class="mb-8 mt-5">

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Jauna kategorija
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Pievienot jaunu kategoriju
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Izveido jaunu galveno kategoriju vai pievieno apakškategoriju esošai kategorijai.
        </p>

    </div>


    <!-- VALIDATION ERRORS -->
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-400/10">

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

                <div>

                    <p class="font-bold">
                        Lūdzu pārbaudi ievadītos datus.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <!-- FORM -->
    <form
        method="POST"
        action="{{ route('categories.store') }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]"
    >

        @csrf


        <!-- FORM HEADER -->
        <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:px-8">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

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

                </div>

                <div>

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Kategorijas informācija
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Norādi kategorijas nosaukumu, hierarhiju un aprakstu
                    </p>

                </div>

            </div>

        </div>


        <!-- FORM BODY -->
        <div class="p-6 sm:p-8">

            <!-- CATEGORY NAME -->
            <div class="mb-7">

                <label
                    for="name"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Kategorijas nosaukums
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Piemēram, Portatīvie datori"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

            </div>


            <!-- PARENT CATEGORY -->
            <div class="mb-7">

                <label
                    for="parent_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Vecākkategorija
                </label>

                <select
                    id="parent_id"
                    name="parent_id"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Nav — galvenā kategorija
                    </option>

                    @foreach($categories as $parentCategory)

                        <option
                            value="{{ $parentCategory->id }}"
                            @selected(old('parent_id') == $parentCategory->id)
                        >

                            @if($parentCategory->parent)

                                {{ $parentCategory->parent->name }} → {{ $parentCategory->name }}

                            @else

                                {{ $parentCategory->name }}

                            @endif

                        </option>

                    @endforeach

                </select>


                <!-- HIERARCHY INFO -->
                <div
                    id="category-type-info"
                    class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-400/15 dark:bg-emerald-400/[0.06]"
                >

                    <div class="flex items-start gap-3">

                        <svg
                            class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        <div>

                            <p
                                id="category-type-title"
                                class="text-sm font-bold text-emerald-800 dark:text-emerald-200"
                            >
                                Galvenā kategorija
                            </p>

                            <p
                                id="category-type-text"
                                class="mt-1 text-xs leading-5 text-emerald-700/80 dark:text-emerald-300/70"
                            >
                                Ja vecākkategorija nav izvēlēta, kategorija tiks izveidota kā galvenā kategorija.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- DESCRIPTION -->
            <div>

                <label
                    for="description"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Apraksts
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Īss kategorijas apraksts..."
                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >{{ old('description') }}</textarea>

                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                    Apraksts nav obligāts.
                </p>

            </div>


            <!-- BUTTONS -->
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 dark:border-emerald-400/10 sm:flex-row">

                <a
                    href="{{ route('categories.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                >
                    Atcelt
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300"
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

                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const parentSelect =
        document.getElementById('parent_id');

    const categoryTypeTitle =
        document.getElementById('category-type-title');

    const categoryTypeText =
        document.getElementById('category-type-text');


    function updateCategoryInformation() {

        if (parentSelect.value) {

            const selectedOption =
                parentSelect.options[parentSelect.selectedIndex];

            categoryTypeTitle.textContent =
                'Apakškategorija';

            categoryTypeText.textContent =
                'Jaunā kategorija tiks izveidota zem kategorijas "' +
                selectedOption.text.trim() +
                '".';

        } else {

            categoryTypeTitle.textContent =
                'Galvenā kategorija';

            categoryTypeText.textContent =
                'Ja vecākkategorija nav izvēlēta, kategorija tiks izveidota kā galvenā kategorija.';

        }

    }


    parentSelect.addEventListener(
        'change',
        updateCategoryInformation
    );


    updateCategoryInformation();

});
</script>

@endsection