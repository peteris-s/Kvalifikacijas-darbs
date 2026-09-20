@extends('layouts.app')

@section('title', 'Jauns pasūtījums | StockManager')

@section('content')

<div class="mx-auto max-w-6xl">

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Reģistrēt pasūtījumu
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Reģistrē no interneta veikala saņemtu klienta pasūtījumu.
            </p>
        </div>

        <a
            href="{{ route('customer-orders.index') }}"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            Atpakaļ
        </a>

    </div>


    <!-- ERRORS -->
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <p class="font-semibold">
                Pasūtījumu neizdevās saglabāt.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('customer-orders.store') }}"
        class="space-y-6"
    >

        @csrf


        <!-- ORDER INFORMATION -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-6">

                <h2 class="text-lg font-semibold text-gray-900">
                    Pasūtījuma informācija
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Norādi pasūtījuma numuru no interneta veikala.
                </p>

            </div>


            <div>

                <label
                    for="order_number"
                    class="mb-2 block text-sm font-medium text-gray-700"
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
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Pasūtījuma numuram jābūt unikālam.
                </p>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Pasūtītās preces
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Vienam pasūtījumam vari pievienot vairākas preces.
                    </p>

                </div>


                <button
                    type="button"
                    id="add-product"
                    class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    + Pievienot preci
                </button>

            </div>


            <!-- PRODUCT ROWS -->
            <div
                id="product-rows"
                class="space-y-4"
            >

                <!-- FIRST ROW -->
                <div
                    class="product-row rounded-xl border border-gray-200 bg-gray-50 p-5"
                >

                    <div class="grid gap-5 md:grid-cols-[1fr_180px_auto] md:items-end">

                        <!-- PRODUCT -->
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Prece
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="products[0][product_id]"
                                required
                                class="product-select w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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


                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">

                                <span>
                                    Pieejams:
                                    <strong class="available-quantity text-gray-700">
                                        -
                                    </strong>
                                </span>

                                <span>
                                    Atrašanās vieta:
                                    <strong class="product-location text-gray-700">
                                        -
                                    </strong>
                                </span>

                            </div>

                        </div>


                        <!-- QUANTITY -->
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Daudzums
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                name="products[0][quantity]"
                                value="1"
                                min="1"
                                required
                                class="product-quantity w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >

                        </div>


                        <!-- REMOVE -->
                        <div>

                            <button
                                type="button"
                                class="remove-product rounded-lg border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                            >
                                Noņemt
                            </button>

                        </div>

                    </div>


                    <p class="stock-warning mt-3 hidden text-sm font-medium text-amber-600">
                        Uzmanību: pasūtītais daudzums pārsniedz pašreizējo noliktavas atlikumu.
                    </p>

                </div>

            </div>

        </div>


        <!-- NOTES -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Papildu informācija
            </h2>

            <div class="mt-5">

                <label
                    for="notes"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Piezīmes
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Piemēram: Klienta pasūtījums no interneta veikala."
                    class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >{{ old('notes') }}</textarea>

            </div>

        </div>


        <!-- BUTTONS -->
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('customer-orders.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-5 py-3 font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                Reģistrēt pasūtījumu
            </button>

        </div>

    </form>

</div>


<!-- TEMPLATE FOR NEW PRODUCT ROWS -->
<template id="product-row-template">

    <div class="product-row rounded-xl border border-gray-200 bg-gray-50 p-5">

        <div class="grid gap-5 md:grid-cols-[1fr_180px_auto] md:items-end">

            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Prece
                    <span class="text-red-500">*</span>
                </label>

                <select
                    data-name="product_id"
                    required
                    class="product-select w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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


                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">

                    <span>
                        Pieejams:
                        <strong class="available-quantity text-gray-700">
                            -
                        </strong>
                    </span>

                    <span>
                        Atrašanās vieta:
                        <strong class="product-location text-gray-700">
                            -
                        </strong>
                    </span>

                </div>

            </div>


            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Daudzums
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    data-name="quantity"
                    value="1"
                    min="1"
                    required
                    class="product-quantity w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

            </div>


            <div>

                <button
                    type="button"
                    class="remove-product rounded-lg border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                >
                    Noņemt
                </button>

            </div>

        </div>


        <p class="stock-warning mt-3 hidden text-sm font-medium text-amber-600">
            Uzmanību: pasūtītais daudzums pārsniedz pašreizējo noliktavas atlikumu.
        </p>

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