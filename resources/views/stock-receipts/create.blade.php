@extends('layouts.app')

@section('title', 'Reģistrēt saņemšanu | StockManager')
@section('page-title', 'Preču saņemšana')

@section('content')

<div class="mx-auto max-w-5xl">

    <a
        href="{{ route('stock-receipts.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-300">
        ← Atpakaļ uz preču saņemšanu
    </a>


    <div class="mb-8 mt-5">
        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">Jauna piegāde</span>
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Reģistrēt preču saņemšanu
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Ievadi pavadzīmes informāciju un saņemtās preces.
        </p>
    </div>


    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

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
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18] sm:p-8">

        @csrf


        <!-- DOCUMENT INFORMATION -->
        <div class="mb-8">

            <div class="mb-5 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <path d="M14 2v6h6"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Pavadzīmes informācija</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <!-- DOCUMENT NUMBER -->
                <div>

                    <label
                        for="document_number"
                        class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                        Pavadzīmes numurs
                    </label>

                    <input
                        type="text"
                        id="document_number"
                        name="document_number"
                        value="{{ old('document_number') }}"
                        required
                        placeholder="Piemēram, PAV-001"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]">

                </div>


                <!-- DATE -->
                <div>

                    <label
                        for="received_at"
                        class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                        Saņemšanas datums un laiks
                    </label>

                    <input
                        type="datetime-local"
                        id="received_at"
                        name="received_at"
                        value="{{ old('received_at', now()->format('Y-m-d\TH:i')) }}"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]">

                </div>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div>

            <div class="mb-4 flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                        Saņemtās preces
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Pievieno visas preces, kas norādītas pavadzīmē.
                    </p>
                </div>

                <button
                    type="button"
                    id="add-product"
                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:bg-emerald-400/15">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>
                    Pievienot preci
                </button>

            </div>


            <!-- PRODUCT ROWS -->
            <div id="product-list" class="space-y-4">

                <div class="product-row rounded-xl border border-slate-200 bg-slate-50/70 p-4 dark:border-emerald-400/10 dark:bg-emerald-400/[0.035]">

                    <div class="grid items-end gap-4 md:grid-cols-12">

                        <!-- PRODUCT -->
                        <div class="md:col-span-7">

                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                                Prece
                            </label>

                            <select
                                name="products[0][product_id]"
                                required
                                class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50">

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

                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                                Daudzums
                            </label>

                            <input
                                type="number"
                                name="products[0][quantity]"
                                value="{{ old('products.0.quantity') }}"
                                min="1"
                                required
                                placeholder="10"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50">

                        </div>


                        <!-- REMOVE -->
                        <div class="md:col-span-2">

                            <button
                                type="button"
                                class="remove-product w-full rounded-xl bg-red-50 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15">
                                Dzēst
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- BUTTONS -->
        <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 dark:border-emerald-400/10 sm:flex-row">

            <a
                href="{{ route('stock-receipts.index') }}"
                class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">
                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300">
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
                'product-row rounded-xl border border-slate-200 bg-slate-50/70 p-4 dark:border-emerald-400/10 dark:bg-emerald-400/[0.035]';

            row.innerHTML = `
                <div class="grid items-end gap-4 md:grid-cols-12">

                    <div class="md:col-span-7">

                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Prece
                        </label>

                        <select
                            name="products[${productIndex}][product_id]"
                            required
                            class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50">

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

                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Daudzums
                        </label>

                        <input
                            type="number"
                            name="products[${productIndex}][quantity]"
                            min="1"
                            required
                            placeholder="10"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50">

                    </div>


                    <div class="md:col-span-2">

                        <button
                            type="button"
                            class="remove-product w-full rounded-xl bg-red-50 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/15">
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