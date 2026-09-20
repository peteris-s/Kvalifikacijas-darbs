@extends('layouts.app')

@section('title', 'Reģistrēt saņemšanu | StockManager')
@section('page-title', 'Preču saņemšana')

@section('content')

<div class="mx-auto max-w-5xl">

    <a
        href="{{ route('stock-receipts.index') }}"
        class="text-sm font-medium text-blue-600 hover:underline">
        ← Atpakaļ uz preču saņemšanu
    </a>


    <div class="mb-6 mt-3">
        <h1 class="text-3xl font-bold text-gray-800">
            Reģistrēt preču saņemšanu
        </h1>

        <p class="mt-1 text-gray-500">
            Ievadi pavadzīmes informāciju un saņemtās preces.
        </p>
    </div>


    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 p-4 text-red-700">

            <p class="font-semibold">
                Lūdzu pārbaudi ievadītos datus.
            </p>

            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <form
        method="POST"
        action="{{ route('stock-receipts.store') }}"
        class="rounded-xl bg-white p-8 shadow-sm">

        @csrf


        <!-- DOCUMENT INFORMATION -->
        <div class="mb-8">

            <h2 class="mb-5 text-xl font-semibold text-gray-800">
                Pavadzīmes informācija
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <!-- DOCUMENT NUMBER -->
                <div>

                    <label
                        for="document_number"
                        class="mb-2 block font-medium text-gray-700">
                        Pavadzīmes numurs
                    </label>

                    <input
                        type="text"
                        id="document_number"
                        name="document_number"
                        value="{{ old('document_number') }}"
                        required
                        placeholder="Piemēram, PAV-001"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                </div>


                <!-- DATE -->
                <div>

                    <label
                        for="received_at"
                        class="mb-2 block font-medium text-gray-700">
                        Saņemšanas datums un laiks
                    </label>

                    <input
                        type="datetime-local"
                        id="received_at"
                        name="received_at"
                        value="{{ old('received_at', now()->format('Y-m-d\TH:i')) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                </div>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div>

            <div class="mb-4 flex items-center justify-between">

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Saņemtās preces
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Pievieno visas preces, kas norādītas pavadzīmē.
                    </p>
                </div>

                <button
                    type="button"
                    id="add-product"
                    class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">
                    + Pievienot preci
                </button>

            </div>


            <!-- PRODUCT ROWS -->
            <div id="product-list" class="space-y-4">

                <div class="product-row rounded-lg border border-gray-200 bg-gray-50 p-4">

                    <div class="grid items-end gap-4 md:grid-cols-12">

                        <!-- PRODUCT -->
                        <div class="md:col-span-7">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Prece
                            </label>

                            <select
                                name="products[0][product_id]"
                                required
                                class="product-select w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-blue-500">

                                <option value="">
                                    Izvēlies preci
                                </option>

                                @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        @selected(old('products.0.product_id') == $product->id)>

                                        {{ $product->name }}
                                        — atlikums: {{ $product->quantity }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- QUANTITY -->
                        <div class="md:col-span-3">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Daudzums
                            </label>

                            <input
                                type="number"
                                name="products[0][quantity]"
                                value="{{ old('products.0.quantity') }}"
                                min="1"
                                required
                                placeholder="10"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-blue-500">

                        </div>


                        <!-- REMOVE -->
                        <div class="md:col-span-2">

                            <button
                                type="button"
                                class="remove-product w-full rounded-lg bg-red-100 px-4 py-3 font-medium text-red-600 transition hover:bg-red-200">
                                Dzēst
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- BUTTONS -->
        <div class="mt-8 flex justify-end gap-3 border-t pt-6">

            <a
                href="{{ route('stock-receipts.index') }}"
                class="rounded-lg border border-gray-300 px-5 py-3 font-medium text-gray-700 transition hover:bg-gray-50">
                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition hover:bg-blue-700">
                Reģistrēt saņemšanu
            </button>

        </div>

    </form>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const productList = document.getElementById('product-list');
        const addProductButton = document.getElementById('add-product');

        let productIndex = 1;


        // ADD NEW PRODUCT
        addProductButton.addEventListener('click', function () {

            const row = document.createElement('div');

            row.className =
                'product-row rounded-lg border border-gray-200 bg-gray-50 p-4';

            row.innerHTML = `
                <div class="grid items-end gap-4 md:grid-cols-12">

                    <div class="md:col-span-7">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Prece
                        </label>

                        <select
                            name="products[${productIndex}][product_id]"
                            required
                            class="product-select w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-blue-500">

                            <option value="">
                                Izvēlies preci
                            </option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} — atlikums: {{ $product->quantity }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="md:col-span-3">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Daudzums
                        </label>

                        <input
                            type="number"
                            name="products[${productIndex}][quantity]"
                            min="1"
                            required
                            placeholder="10"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-blue-500">

                    </div>


                    <div class="md:col-span-2">

                        <button
                            type="button"
                            class="remove-product w-full rounded-lg bg-red-100 px-4 py-3 font-medium text-red-600 transition hover:bg-red-200">
                            Dzēst
                        </button>

                    </div>

                </div>
            `;

            productList.appendChild(row);

            productIndex++;
        });


        // REMOVE PRODUCT
        productList.addEventListener('click', function (event) {

            if (!event.target.classList.contains('remove-product')) {
                return;
            }

            const rows = productList.querySelectorAll('.product-row');

            if (rows.length <= 1) {
                alert('Pavadzīmē jābūt vismaz vienai precei.');
                return;
            }

            event.target.closest('.product-row').remove();
        });

    });
</script>

@endsection