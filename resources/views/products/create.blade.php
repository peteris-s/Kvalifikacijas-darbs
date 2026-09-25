@extends('layouts.app')

@section('title', 'Pievienot preci | StockManager')
@section('page-title', 'Pievienot preci')

@section('content')

<div class="mx-auto max-w-3xl">

    {{-- BACK --}}
    <a
        href="{{ route('products.index') }}"
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

        Atpakaļ uz precēm
    </a>


    {{-- HEADER --}}
    <div class="mb-8 mt-5">

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Jauna prece
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Pievienot preci
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Pievieno jaunu preci noliktavas sistēmai.
        </p>

    </div>


    {{-- VALIDATION ERRORS --}}
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


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('products.store') }}"
        enctype="multipart/form-data"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]"
    >

        @csrf


        {{-- FORM HEADER --}}
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
                        <path d="m21 8-9 5-9-5"/>
                        <path d="m3 8 9-5 9 5v8l-9 5-9-5Z"/>
                        <path d="M12 13v8"/>
                    </svg>

                </div>

                <div>

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Preces informācija
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Norādi preces pamatinformāciju un noliktavas parametrus
                    </p>

                </div>

            </div>

        </div>


        {{-- FORM BODY --}}
        <div class="p-6 sm:p-8">


            {{-- PRODUCT NAME --}}
            <div class="mb-7">

                <label
                    for="name"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Preces nosaukums
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Piemēram, Amiri Jeans"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

            </div>


            {{-- CATEGORY --}}
            <div class="mb-7">

                <label
                    for="category_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Kategorija
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Izvēlies kategoriju
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id') == $category->id)
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- WAREHOUSE LOCATION --}}
            <div class="mb-7">

                <label
                    for="warehouse_location_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Noliktavas vieta
                </label>

                <select
                    id="warehouse_location_id"
                    name="warehouse_location_id"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Nav norādīta
                    </option>

                    @foreach($warehouseLocations as $location)

                        <option
                            value="{{ $location->id }}"
                            @selected(old('warehouse_location_id') == $location->id)
                        >
                            {{ $location->parent?->name ?? 'Bez zonas' }}
                            → {{ $location->name }}
                        </option>

                    @endforeach

                </select>


                <div class="mt-3 flex items-start gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 dark:border-emerald-400/15 dark:bg-emerald-400/[0.06]">

                    <svg
                        class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-300"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 21s6-4.35 6-11a6 6 0 1 0-12 0c0 6.65 6 11 6 11Z"/>
                        <circle cx="12" cy="10" r="2"/>
                    </svg>

                    <div>

                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-200">
                            Preces atrašanās vieta
                        </p>

                        <p class="mt-1 text-xs leading-5 text-emerald-700/80 dark:text-emerald-300/70">
                            Izvēlies konkrētu plauktu, kurā prece atrodas.
                        </p>

                    </div>

                </div>


                @if($warehouseLocations->isEmpty())

                    <p class="mt-3 text-sm font-semibold text-orange-600 dark:text-orange-400">
                        Nav izveidots neviens plaukts.
                    </p>

                @endif

            </div>


            {{-- PRICE / QUANTITY --}}
            <div class="mb-7 grid gap-6 md:grid-cols-2">


                {{-- PRICE --}}
                <div>

                    <label
                        for="price"
                        class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                    >
                        Cena (€)
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            step="0.01"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                        >

                        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-sm font-bold text-slate-400 dark:text-slate-500">
                            €
                        </span>

                    </div>

                </div>


                {{-- QUANTITY --}}
                <div>

                    <label
                        for="quantity"
                        class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                    >
                        Daudzums
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity', 0) }}"
                            min="0"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-16 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                        >

                        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs font-bold text-slate-400 dark:text-slate-500">
                            gab.
                        </span>

                    </div>

                </div>

            </div>


            {{-- MINIMUM QUANTITY --}}
            <div class="mb-7">

                <label
                    for="minimum_quantity"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Minimālais atlikums
                </label>

                <div class="relative">

                    <input
                        type="number"
                        id="minimum_quantity"
                        name="minimum_quantity"
                        value="{{ old('minimum_quantity', 0) }}"
                        min="0"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-16 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                    >

                    <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs font-bold text-slate-400 dark:text-slate-500">
                        gab.
                    </span>

                </div>

                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                    Sasniedzot šo atlikumu, prece tiks iekļauta iepirkumu plānošanā.
                </p>

            </div>


            {{-- IMAGE --}}
            <div>

                <div class="mb-2 flex items-center justify-between gap-4">

                    <label
                        for="image"
                        class="block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                    >
                        Preces attēls
                    </label>

                    <span class="text-xs text-slate-400 dark:text-slate-500">
                        Nav obligāts
                    </span>

                </div>


                <label
                    for="image"
                    class="flex cursor-pointer items-center gap-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-5 transition hover:border-emerald-400 hover:bg-emerald-50/50 dark:border-emerald-400/15 dark:bg-[#091512] dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/[0.05]"
                >

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 16V4"/>
                            <path d="m7 9 5-5 5 5"/>
                            <path d="M5 20h14"/>
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200">
                            Izvēlēties attēlu
                        </p>

                        <p
                            id="image-file-name"
                            class="mt-1 truncate text-xs text-slate-400 dark:text-slate-500"
                        >
                            JPG, PNG vai cits attēla fails
                        </p>

                    </div>

                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="hidden"
                >

            </div>


            {{-- ACTIONS --}}
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 dark:border-emerald-400/10 sm:flex-row">

                <a
                    href="{{ route('products.index') }}"
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

                    Pievienot preci

                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput =
        document.getElementById('image');

    const imageFileName =
        document.getElementById('image-file-name');

    imageInput.addEventListener('change', function () {

        if (imageInput.files.length > 0) {

            imageFileName.textContent =
                'Izvēlēts: ' + imageInput.files[0].name;

        } else {

            imageFileName.textContent =
                'JPG, PNG vai cits attēla fails';

        }

    });

});
</script>

@endsection