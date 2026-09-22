@extends('layouts.app')

@section('title', 'Jauna izsniegšana | StockManager')
@section('page-title', 'Preču izsniegšana')

@section('content')

<div class="mx-auto max-w-5xl">

    <!-- HEADER -->
    <div class="mb-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                    <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                        Jauna izsniegšana
                    </span>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Reģistrēt preču izsniegšanu
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Reģistrē vienu vai vairākas preces klienta pasūtījuma izpildei.
                </p>
            </div>

            <a
                href="{{ route('stock-issues.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
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
                        Neizdevās reģistrēt izsniegšanu.
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
        action="{{ route('stock-issues.store') }}"
        class="space-y-6"
    >
        @csrf


        <!-- ORDER -->
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
                            <path d="M6 2h9l5 5v15H6z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M9 13h6"/>
                            <path d="M9 17h6"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-slate-900 dark:text-white">
                            Pasūtījuma informācija
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Norādi pasūtījumu, kuram preces tiek izsniegtas
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
                    placeholder="Piemēram: ORD-1042"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                <p class="mt-2 text-xs text-slate-500 dark:text-slate-500">
                    Ievadi pasūtījuma numuru no interneta veikala.
                </p>

            </div>

        </div>


        <!-- PRODUCTS -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <!-- PRODUCTS HEADER -->
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
                            Izsniedzamās preces
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Vienam pasūtījumam vari pievienot vairākas preces
                        </p>
                    </div>

                </div>


                <button
                    type="button"
                    id="add-product-button"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-400/25 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:bg-emerald-400/15"
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

                @php
                    $oldProducts = old('products', [
                        [
                            'product_id' => '',
                            'quantity' => 1,
                        ]
                    ]);
                @endphp


                @foreach ($oldProducts as $index => $oldProduct)

                    <div
                        class="product-row rounded-2xl border border-slate-200 bg-slate-50/70 p-5 dark:border-emerald-400/10 dark:bg-[#091512]"
                    >

                        <!-- ROW HEADER -->
                        <div class="mb-5 flex items-center justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300 product-number">
                                    {{ $index + 1 }}
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                                        Prece
                                    </p>

                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                        Izvēlies preci un daudzumu
                                    </p>
                                </div>

                            </div>


                            <button
                                type="button"
                                class="remove-product-button inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-400/10"
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

                                Noņemt
                            </button>

                        </div>


                        <div class="grid gap-5 md:grid-cols-[1fr_180px]">

                            <!-- PRODUCT SELECT -->
                            <div>

                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                                >
                                    Prece
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="products[{{ $index }}][product_id]"
                                    required
                                    class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0b1916] dark:text-slate-100 dark:focus:border-emerald-400/50"
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
                                            data-minimum="{{ $product->minimum_quantity }}"
                                            data-location="{{ $location }}"
                                            @selected(
                                                ($oldProduct['product_id'] ?? '') == $product->id
                                            )
                                        >
                                            {{ $product->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <!-- QUANTITY -->
                            <div>

                                <label
                                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                                >
                                    Daudzums
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="products[{{ $index }}][quantity]"
                                    value="{{ $oldProduct['quantity'] ?? 1 }}"
                                    min="1"
                                    required
                                    class="product-quantity w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0b1916] dark:text-slate-100 dark:focus:border-emerald-400/50"
                                >

                            </div>

                        </div>


                        <!-- PRODUCT INFORMATION -->
                        <div class="product-info mt-5 hidden">

                            <div class="grid gap-3 sm:grid-cols-3">

                                <!-- AVAILABLE -->
                                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Pieejams
                                    </p>

                                    <p class="available-quantity mt-1.5 text-lg font-bold text-slate-900 dark:text-white">
                                        -
                                    </p>

                                </div>


                                <!-- REMAINING -->
                                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Atliks pēc izsniegšanas
                                    </p>

                                    <p class="remaining-quantity mt-1.5 text-lg font-bold text-slate-900 dark:text-white">
                                        -
                                    </p>

                                </div>


                                <!-- LOCATION -->
                                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                                        Atrašanās vieta
                                    </p>

                                    <p class="product-location mt-1.5 text-sm font-bold text-slate-900 dark:text-white">
                                        -
                                    </p>

                                </div>

                            </div>


                            <!-- MINIMUM -->
                            <div class="mt-3 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    Minimālais atlikums
                                </span>

                                <span class="minimum-quantity text-xs font-bold text-slate-700 dark:text-slate-200">
                                    -
                                </span>

                            </div>


                            <!-- WARNING -->
                            <div class="quantity-warning mt-3 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 dark:border-red-400/20 dark:bg-red-400/10">

                                <div class="flex items-center gap-2">

                                    <svg
                                        class="h-4 w-4 shrink-0 text-red-500 dark:text-red-300"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 8v4"/>
                                        <path d="M12 16h.01"/>
                                    </svg>

                                    <p class="text-xs font-bold text-red-700 dark:text-red-300">
                                        Noliktavā nav pietiekams preces daudzums.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        <!-- NOTES -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10">

                <h2 class="font-bold text-slate-900 dark:text-white">
                    Papildu informācija
                </h2>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Piezīmes tiks saglabātas pie izsniegšanas ierakstiem
                </p>

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
                    placeholder="Piemēram: Klienta pasūtījums sagatavots nosūtīšanai."
                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >{{ old('notes') }}</textarea>

            </div>

        </div>


        <!-- ACTIONS -->
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">

            <a
                href="{{ route('stock-issues.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
            >
                Atcelt
            </a>

            <button
                id="submit-button"
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300 focus:outline-none focus:ring-4 focus:ring-emerald-400/15"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M20 6 9 17l-5-5"/>
                </svg>

                Reģistrēt izsniegšanu
            </button>

        </div>

    </form>

</div>


<!-- PRODUCT ROW TEMPLATE -->
<template id="product-row-template">

    <div class="product-row rounded-2xl border border-slate-200 bg-slate-50/70 p-5 dark:border-emerald-400/10 dark:bg-[#091512]">

        <!-- ROW HEADER -->
        <div class="mb-5 flex items-center justify-between gap-4">

            <div class="flex items-center gap-3">

                <div class="product-number flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                    1
                </div>

                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                        Prece
                    </p>

                    <p class="text-xs text-slate-400 dark:text-slate-500">
                        Izvēlies preci un daudzumu
                    </p>
                </div>

            </div>


            <button
                type="button"
                class="remove-product-button inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-400/10"
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

                Noņemt
            </button>

        </div>


        <div class="grid gap-5 md:grid-cols-[1fr_180px]">

            <!-- PRODUCT -->
            <div>

                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                    Prece
                    <span class="text-red-500">*</span>
                </label>

                <select
                    required
                    class="product-select w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0b1916] dark:text-slate-100 dark:focus:border-emerald-400/50"
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
                            data-minimum="{{ $product->minimum_quantity }}"
                            data-location="{{ $location }}"
                        >
                            {{ $product->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- QUANTITY -->
            <div>

                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                    Daudzums
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    value="1"
                    min="1"
                    required
                    class="product-quantity w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#0b1916] dark:text-slate-100 dark:focus:border-emerald-400/50"
                >

            </div>

        </div>


        <!-- PRODUCT INFO -->
        <div class="product-info mt-5 hidden">

            <div class="grid gap-3 sm:grid-cols-3">

                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Pieejams
                    </p>

                    <p class="available-quantity mt-1.5 text-lg font-bold text-slate-900 dark:text-white">
                        -
                    </p>

                </div>


                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Atliks pēc izsniegšanas
                    </p>

                    <p class="remaining-quantity mt-1.5 text-lg font-bold text-slate-900 dark:text-white">
                        -
                    </p>

                </div>


                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                        Atrašanās vieta
                    </p>

                    <p class="product-location mt-1.5 text-sm font-bold text-slate-900 dark:text-white">
                        -
                    </p>

                </div>

            </div>


            <div class="mt-3 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 dark:border-emerald-400/10 dark:bg-[#0d1b18]">

                <span class="text-xs text-slate-500 dark:text-slate-400">
                    Minimālais atlikums
                </span>

                <span class="minimum-quantity text-xs font-bold text-slate-700 dark:text-slate-200">
                    -
                </span>

            </div>


            <div class="quantity-warning mt-3 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 dark:border-red-400/20 dark:bg-red-400/10">

                <div class="flex items-center gap-2">

                    <svg
                        class="h-4 w-4 shrink-0 text-red-500 dark:text-red-300"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v4"/>
                        <path d="M12 16h.01"/>
                    </svg>

                    <p class="text-xs font-bold text-red-700 dark:text-red-300">
                        Noliktavā nav pietiekams preces daudzums.
                    </p>

                </div>

            </div>

        </div>

    </div>

</template>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const rowsContainer =
        document.getElementById('product-rows');

    const addProductButton =
        document.getElementById('add-product-button');

    const template =
        document.getElementById('product-row-template');

    const submitButton =
        document.getElementById('submit-button');


    let nextIndex = {{ count($oldProducts) }};


    /*
    |--------------------------------------------------------------------------
    | Update row information
    |--------------------------------------------------------------------------
    */

    function updateRow(row) {

        const productSelect =
            row.querySelector('.product-select');

        const quantityInput =
            row.querySelector('.product-quantity');

        const productInfo =
            row.querySelector('.product-info');

        const availableQuantity =
            row.querySelector('.available-quantity');

        const minimumQuantity =
            row.querySelector('.minimum-quantity');

        const productLocation =
            row.querySelector('.product-location');

        const remainingQuantity =
            row.querySelector('.remaining-quantity');

        const quantityWarning =
            row.querySelector('.quantity-warning');


        const selectedOption =
            productSelect.options[
                productSelect.selectedIndex
            ];


        if (!selectedOption || !selectedOption.value) {

            productInfo.classList.add('hidden');

            updateSubmitButton();

            return;
        }


        const available =
            parseInt(
                selectedOption.dataset.quantity || 0
            );


        const minimum =
            parseInt(
                selectedOption.dataset.minimum || 0
            );


        const location =
            selectedOption.dataset.location ||
            'Nav norādīta';


        const issueQuantity =
            parseInt(
                quantityInput.value || 0
            );


        const remaining =
            available - issueQuantity;


        productInfo.classList.remove('hidden');


        availableQuantity.textContent =
            available + ' gab.';


        minimumQuantity.textContent =
            minimum + ' gab.';


        productLocation.textContent =
            location;


        remainingQuantity.textContent =
            remaining + ' gab.';


        if (
            issueQuantity < 1 ||
            issueQuantity > available
        ) {

            quantityWarning.classList.remove('hidden');

            remainingQuantity.classList.remove(
                'text-slate-900',
                'dark:text-white'
            );

            remainingQuantity.classList.add(
                'text-red-600',
                'dark:text-red-300'
            );

        } else {

            quantityWarning.classList.add('hidden');

            remainingQuantity.classList.remove(
                'text-red-600',
                'dark:text-red-300'
            );

            remainingQuantity.classList.add(
                'text-slate-900',
                'dark:text-white'
            );

        }


        updateSubmitButton();
    }


    /*
    |--------------------------------------------------------------------------
    | Validate all rows
    |--------------------------------------------------------------------------
    */

    function updateSubmitButton() {

        const rows =
            rowsContainer.querySelectorAll('.product-row');


        let hasInvalidRow = false;


        rows.forEach(function (row) {

            const productSelect =
                row.querySelector('.product-select');

            const quantityInput =
                row.querySelector('.product-quantity');


            if (!productSelect.value) {
                return;
            }


            const selectedOption =
                productSelect.options[
                    productSelect.selectedIndex
                ];


            const available =
                parseInt(
                    selectedOption.dataset.quantity || 0
                );


            const quantity =
                parseInt(
                    quantityInput.value || 0
                );


            if (
                quantity < 1 ||
                quantity > available
            ) {
                hasInvalidRow = true;
            }

        });


        submitButton.disabled =
            hasInvalidRow;


        if (hasInvalidRow) {

            submitButton.classList.add(
                'cursor-not-allowed',
                'opacity-50'
            );

        } else {

            submitButton.classList.remove(
                'cursor-not-allowed',
                'opacity-50'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update row numbers
    |--------------------------------------------------------------------------
    */

    function updateRowNumbers() {

        const rows =
            rowsContainer.querySelectorAll('.product-row');


        rows.forEach(function (row, index) {

            const number =
                row.querySelector('.product-number');


            if (number) {
                number.textContent =
                    index + 1;
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Bind row events
    |--------------------------------------------------------------------------
    */

    function bindRow(row) {

        const productSelect =
            row.querySelector('.product-select');

        const quantityInput =
            row.querySelector('.product-quantity');

        const removeButton =
            row.querySelector('.remove-product-button');


        productSelect.addEventListener(
            'change',
            function () {
                updateRow(row);
            }
        );


        quantityInput.addEventListener(
            'input',
            function () {
                updateRow(row);
            }
        );


        removeButton.addEventListener(
            'click',
            function () {

                const rows =
                    rowsContainer.querySelectorAll('.product-row');


                if (rows.length <= 1) {
                    return;
                }


                row.remove();

                updateRowNumbers();

                updateSubmitButton();
            }
        );


        updateRow(row);
    }


    /*
    |--------------------------------------------------------------------------
    | Add product
    |--------------------------------------------------------------------------
    */

    addProductButton.addEventListener(
        'click',
        function () {

            const clone =
                template.content.cloneNode(true);


            const row =
                clone.querySelector('.product-row');


            const productSelect =
                row.querySelector('.product-select');

            const quantityInput =
                row.querySelector('.product-quantity');


            productSelect.name =
                `products[${nextIndex}][product_id]`;


            quantityInput.name =
                `products[${nextIndex}][quantity]`;


            nextIndex++;


            rowsContainer.appendChild(row);


            bindRow(row);

            updateRowNumbers();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Existing rows
    |--------------------------------------------------------------------------
    */

    rowsContainer
        .querySelectorAll('.product-row')
        .forEach(function (row) {
            bindRow(row);
        });


    updateRowNumbers();

});
</script>

@endsection