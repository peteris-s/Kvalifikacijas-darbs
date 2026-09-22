@extends('layouts.app')

@section('title', 'Jauns pasūtījums | StockManager')
@section('page-title', 'Jauns pasūtījums')

@section('content')

<div class="mx-auto max-w-6xl">

    <!-- HEADER -->
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                    Jauns klienta pasūtījums
                </span>

            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Reģistrēt pasūtījumu
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Reģistrē no interneta veikala saņemtu klienta pasūtījumu.
            </p>

        </div>


        <a
            href="{{ route('customer-orders.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:text-slate-300 dark:hover:border-emerald-400/30 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
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

            Atpakaļ

        </a>

    </div>


    <!-- ERRORS -->
    @if ($errors->any())

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
                        Pasūtījumu neizdevās saglabāt.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('customer-orders.store') }}"
        class="space-y-6"
    >

        @csrf


        <!-- ORDER INFORMATION -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M6 2h9l5 5v15H6Z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M9 13h7"/>
                            <path d="M9 17h7"/>
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-slate-900 dark:text-white">
                            Pasūtījuma informācija
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Norādi pasūtījuma numuru no interneta veikala
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                <label
                    for="order_number"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Pasūtījuma numurs
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    id="order_number"
                    name="order_number"
                    value="{{ old('order_number') }}"
                    placeholder="Piemēram: ORD-1002"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                <div class="mt-3 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">

                    <svg
                        class="h-3.5 w-3.5 text-emerald-500"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 11v5"/>
                        <path d="M12 8h.01"/>
                    </svg>

                    Pasūtījuma numuram jābūt unikālam.

                </div>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">

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
                            Pasūtītās preces
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Vienam pasūtījumam vari pievienot vairākas preces
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    id="add-product"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:bg-emerald-400/15"
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


            <!-- PRODUCT ROWS -->
            <div
                id="product-rows"
                class="space-y-4 p-6"
            >

                <!-- FIRST ROW -->
                <div class="product-row rounded-xl border border-slate-200 bg-slate-50/60 p-5 dark:border-emerald-400/10 dark:bg-[#091512]">

                    <div class="grid gap-5 md:grid-cols-[1fr_180px_auto] md:items-end">

                        <!-- PRODUCT -->
                        <div>

                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                                Prece
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="products[0][product_id]"
                                required
                                class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0d1b18] dark:text-slate-100 dark:focus:border-emerald-400/50"
                            >

                                <option value="">
                                    Izvēlies preci
                                </option>

                                @foreach ($products as $product)

                                    @php
                                        $location = 'Nav norādīta';

                                        if ($product->warehouseLocation) {

                                            if ($product->warehouseLocation->parent) {

                                                $location =
                                                    $product->warehouseLocation->parent->name
                                                    . ' → '
                                                    . $product->warehouseLocation->name;

                                            } else {

                                                $location =
                                                    $product->warehouseLocation->name;
                                            }
                                        }
                                    @endphp

                                    <option
                                        value="{{ $product->id }}"
                                        data-quantity="{{ $product->quantity }}"
                                        data-location="{{ $location }}"
                                    >
                                        {{ $product->name }}
                                        — {{ $product->quantity }} gab.
                                    </option>

                                @endforeach

                            </select>


                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-500 dark:text-slate-400">

                                <span class="inline-flex items-center gap-1.5">

                                    <svg
                                        class="h-3.5 w-3.5 text-emerald-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="m21 8-9 5-9-5"/>
                                        <path d="m3 8 9-5 9 5v8l-9 5-9-5Z"/>
                                    </svg>

                                    Pieejams:

                                    <strong class="available-quantity text-slate-700 dark:text-slate-200">
                                        -
                                    </strong>

                                </span>


                                <span class="inline-flex items-center gap-1.5">

                                    <svg
                                        class="h-3.5 w-3.5 text-emerald-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M12 21s6-4.35 6-11a6 6 0 1 0-12 0c0 6.65 6 11 6 11Z"/>
                                        <circle cx="12" cy="10" r="2"/>
                                    </svg>

                                    Atrašanās vieta:

                                    <strong class="product-location text-slate-700 dark:text-slate-200">
                                        -
                                    </strong>

                                </span>

                            </div>

                        </div>


                        <!-- QUANTITY -->
                        <div>

                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                                Daudzums
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                name="products[0][quantity]"
                                value="1"
                                min="1"
                                required
                                class="product-quantity w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0d1b18] dark:text-slate-100 dark:focus:border-emerald-400/50"
                            >

                        </div>


                        <!-- REMOVE -->
                        <div>

                            <button
                                type="button"
                                class="remove-product inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15"
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
                                </svg>

                                Noņemt

                            </button>

                        </div>

                    </div>


                    <div class="stock-warning mt-4 hidden rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-300">

                        <div class="flex items-center gap-2">

                            <svg
                                class="h-4 w-4 shrink-0"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M10.3 2.9 1.8 17a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 2.9a2 2 0 0 0-3.4 0Z"/>
                                <path d="M12 9v4"/>
                                <path d="M12 17h.01"/>
                            </svg>

                            Uzmanību: pasūtītais daudzums pārsniedz pašreizējo noliktavas atlikumu.

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- NOTES -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M4 5h16"/>
                            <path d="M4 10h16"/>
                            <path d="M4 15h10"/>
                            <path d="M4 20h8"/>
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-slate-900 dark:text-white">
                            Papildu informācija
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Pievieno piezīmes par klienta pasūtījumu
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                <label
                    for="notes"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Piezīmes
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Piemēram: Klienta pasūtījums no interneta veikala."
                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >{{ old('notes') }}</textarea>

                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                    Piezīmes nav obligātas.
                </p>

            </div>

        </div>


        <!-- BUTTONS -->
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">

            <a
                href="{{ route('customer-orders.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
            >
                Atcelt
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300 focus:outline-none focus:ring-4 focus:ring-emerald-400/20"
            >

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m5 12 4 4L19 6"/>
                </svg>

                Reģistrēt pasūtījumu

            </button>

        </div>

    </form>

</div>


<!-- TEMPLATE FOR NEW PRODUCT ROWS -->
<template id="product-row-template">

    <div class="product-row rounded-xl border border-slate-200 bg-slate-50/60 p-5 dark:border-emerald-400/10 dark:bg-[#091512]">

        <div class="grid gap-5 md:grid-cols-[1fr_180px_auto] md:items-end">

            <!-- PRODUCT -->
            <div>

                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                    Prece
                    <span class="text-red-500">*</span>
                </label>

                <select
                    data-name="product_id"
                    required
                    class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0d1b18] dark:text-slate-100 dark:focus:border-emerald-400/50"
                >

                    <option value="">
                        Izvēlies preci
                    </option>

                    @foreach ($products as $product)

                        @php
                            $location = 'Nav norādīta';

                            if ($product->warehouseLocation) {

                                if ($product->warehouseLocation->parent) {

                                    $location =
                                        $product->warehouseLocation->parent->name
                                        . ' → '
                                        . $product->warehouseLocation->name;

                                } else {

                                    $location =
                                        $product->warehouseLocation->name;
                                }
                            }
                        @endphp

                        <option
                            value="{{ $product->id }}"
                            data-quantity="{{ $product->quantity }}"
                            data-location="{{ $location }}"
                        >
                            {{ $product->name }}
                            — {{ $product->quantity }} gab.
                        </option>

                    @endforeach

                </select>


                <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-500 dark:text-slate-400">

                    <span class="inline-flex items-center gap-1.5">

                        <svg
                            class="h-3.5 w-3.5 text-emerald-500"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="m21 8-9 5-9-5"/>
                            <path d="m3 8 9-5 9 5v8l-9 5-9-5Z"/>
                        </svg>

                        Pieejams:

                        <strong class="available-quantity text-slate-700 dark:text-slate-200">
                            -
                        </strong>

                    </span>


                    <span class="inline-flex items-center gap-1.5">

                        <svg
                            class="h-3.5 w-3.5 text-emerald-500"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 21s6-4.35 6-11a6 6 0 1 0-12 0c0 6.65 6 11 6 11Z"/>
                            <circle cx="12" cy="10" r="2"/>
                        </svg>

                        Atrašanās vieta:

                        <strong class="product-location text-slate-700 dark:text-slate-200">
                            -
                        </strong>

                    </span>

                </div>

            </div>


            <!-- QUANTITY -->
            <div>

                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                    Daudzums
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    data-name="quantity"
                    value="1"
                    min="1"
                    required
                    class="product-quantity w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0d1b18] dark:text-slate-100 dark:focus:border-emerald-400/50"
                >

            </div>


            <!-- REMOVE -->
            <div>

                <button
                    type="button"
                    class="remove-product inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15"
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
                    </svg>

                    Noņemt

                </button>

            </div>

        </div>


        <div class="stock-warning mt-4 hidden rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 dark:border-amber-400/20 dark:bg-amber-400/10 dark:text-amber-300">

            <div class="flex items-center gap-2">

                <svg
                    class="h-4 w-4 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M10.3 2.9 1.8 17a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 2.9a2 2 0 0 0-3.4 0Z"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                </svg>

                Uzmanību: pasūtītais daudzums pārsniedz pašreizējo noliktavas atlikumu.

            </div>

        </div>

    </div>

</template>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const rowsContainer =
        document.getElementById('product-rows');

    const addButton =
        document.getElementById('add-product');

    const template =
        document.getElementById('product-row-template');

    let nextIndex = 1;


    function updateRow(row) {

        const select =
            row.querySelector('.product-select');

        const quantityInput =
            row.querySelector('.product-quantity');

        const availableText =
            row.querySelector('.available-quantity');

        const locationText =
            row.querySelector('.product-location');

        const warning =
            row.querySelector('.stock-warning');

        const selected =
            select.options[select.selectedIndex];


        if (!selected || !selected.value) {

            availableText.textContent = '-';
            locationText.textContent = '-';
            warning.classList.add('hidden');

            return;
        }


        const available =
            parseInt(selected.dataset.quantity || 0);

        const requested =
            parseInt(quantityInput.value || 0);

        availableText.textContent =
            available + ' gab.';

        locationText.textContent =
            selected.dataset.location || 'Nav norādīta';


        if (requested > available) {

            warning.classList.remove('hidden');

        } else {

            warning.classList.add('hidden');

        }

    }


    function bindRow(row) {

        const select =
            row.querySelector('.product-select');

        const quantityInput =
            row.querySelector('.product-quantity');

        const removeButton =
            row.querySelector('.remove-product');


        select.addEventListener('change', function () {
            updateRow(row);
        });


        quantityInput.addEventListener('input', function () {
            updateRow(row);
        });


        removeButton.addEventListener('click', function () {

            const rows =
                rowsContainer.querySelectorAll('.product-row');

            if (rows.length === 1) {
                return;
            }

            row.remove();

        });


        updateRow(row);

    }


    addButton.addEventListener('click', function () {

        const fragment =
            template.content.cloneNode(true);

        const row =
            fragment.querySelector('.product-row');

        const select =
            row.querySelector('.product-select');

        const quantity =
            row.querySelector('.product-quantity');


        select.name =
            `products[${nextIndex}][product_id]`;

        quantity.name =
            `products[${nextIndex}][quantity]`;

        nextIndex++;


        rowsContainer.appendChild(row);

        bindRow(row);

    });


    document
        .querySelectorAll('.product-row')
        .forEach(function (row) {
            bindRow(row);
        });

});
</script>

@endsection