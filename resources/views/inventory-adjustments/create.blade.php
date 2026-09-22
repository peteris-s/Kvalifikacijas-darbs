@extends('layouts.app')

@section('title', 'Jauna inventarizācija | StockManager')
@section('page-title', 'Inventarizācija')

@section('content')

<div class="mx-auto max-w-3xl">

    <!-- BACK -->
    <a
        href="{{ route('inventory-adjustments.index') }}"
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

        Atpakaļ uz inventarizāciju
    </a>


    <!-- HEADER -->
    <div class="mb-8 mt-5">

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Atlikumu korekcija
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Jauna inventarizācija
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Ievadi faktiski saskaitīto preces daudzumu noliktavā.
        </p>

    </div>


    <!-- ERRORS -->
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
        action="{{ route('inventory-adjustments.store') }}"
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
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>

                </div>

                <div>

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Inventarizācijas dati
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Salīdzini sistēmas atlikumu ar faktiski saskaitīto daudzumu
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6 sm:p-8">

            <!-- PRODUCT -->
            <div class="mb-6">

                <label
                    for="product_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Prece
                </label>

                <select
                    id="product_id"
                    name="product_id"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Izvēlies preci
                    </option>

                    @foreach($products as $product)

                        <option
                            value="{{ $product->id }}"
                            data-quantity="{{ $product->quantity }}"
                            @selected(old('product_id') == $product->id)
                        >
                            {{ $product->name }} — sistēmā: {{ $product->quantity }} gab.
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- QUANTITY COMPARISON -->
            <div class="mb-6 grid gap-4 sm:grid-cols-2">

                <!-- CURRENT -->
                <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5 dark:border-emerald-400/10 dark:bg-emerald-400/[0.035]">

                    <div class="mb-3 flex items-center gap-2">

                        <svg
                            class="h-4 w-4 text-slate-400 dark:text-slate-500"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                        </svg>

                        <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">
                            Sistēmas atlikums
                        </p>

                    </div>

                    <p
                        id="system-quantity"
                        class="text-2xl font-bold text-slate-900 dark:text-white"
                    >
                        —
                    </p>

                </div>


                <!-- DIFFERENCE -->
                <div
                    id="difference-box"
                    class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 transition dark:border-emerald-400/20 dark:bg-emerald-400/10"
                >

                    <div class="mb-3 flex items-center gap-2">

                        <svg
                            class="h-4 w-4 text-emerald-600 dark:text-emerald-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M7 7h10v10"/>
                            <path d="M7 17 17 7"/>
                        </svg>

                        <p
                            id="difference-label"
                            class="text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-600 dark:text-emerald-300"
                        >
                            Aprēķinātā starpība
                        </p>

                    </div>

                    <p
                        id="difference"
                        class="text-2xl font-bold text-emerald-700 dark:text-emerald-300"
                    >
                        —
                    </p>

                </div>

            </div>


            <!-- ACTUAL QUANTITY -->
            <div class="mb-6">

                <label
                    for="actual_quantity"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Faktiski saskaitīts
                </label>

                <input
                    type="number"
                    id="actual_quantity"
                    name="actual_quantity"
                    value="{{ old('actual_quantity') }}"
                    min="0"
                    required
                    placeholder="Piemēram, 25"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

            </div>


            <!-- REASON -->
            <div class="mb-6">

                <label
                    for="reason"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Korekcijas iemesls
                </label>

                <select
                    id="reason"
                    name="reason"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Izvēlies iemeslu
                    </option>

                    <option value="Iztrūkums" @selected(old('reason') === 'Iztrūkums')>
                        Iztrūkums
                    </option>

                    <option value="Pārpalikums" @selected(old('reason') === 'Pārpalikums')>
                        Pārpalikums
                    </option>

                    <option value="Bojāta prece" @selected(old('reason') === 'Bojāta prece')>
                        Bojāta prece
                    </option>

                    <option value="Uzskaites kļūda" @selected(old('reason') === 'Uzskaites kļūda')>
                        Uzskaites kļūda
                    </option>

                    <option value="Cits" @selected(old('reason') === 'Cits')>
                        Cits
                    </option>

                </select>

            </div>


            <!-- NOTES -->
            <div class="mb-6">

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
                    placeholder="Papildu informācija par korekciju..."
                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >{{ old('notes') }}</textarea>

            </div>


            <!-- DATE -->
            <div>

                <label
                    for="adjusted_at"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Inventarizācijas datums un laiks
                </label>

                <input
                    type="datetime-local"
                    id="adjusted_at"
                    name="adjusted_at"
                    value="{{ old('adjusted_at', now()->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

            </div>


            <!-- BUTTONS -->
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 dark:border-emerald-400/10 sm:flex-row">

                <a
                    href="{{ route('inventory-adjustments.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                >
                    Atcelt
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300"
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

                    Reģistrēt korekciju

                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const productSelect = document.getElementById('product_id');
    const actualQuantityInput = document.getElementById('actual_quantity');
    const systemQuantityText = document.getElementById('system-quantity');
    const differenceText = document.getElementById('difference');
    const differenceBox = document.getElementById('difference-box');
    const differenceLabel = document.getElementById('difference-label');


    function resetDifferenceStyles() {

        differenceBox.className =
            'rounded-xl border border-emerald-200 bg-emerald-50 p-5 transition dark:border-emerald-400/20 dark:bg-emerald-400/10';

        differenceLabel.className =
            'text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-600 dark:text-emerald-300';

        differenceText.className =
            'text-2xl font-bold text-emerald-700 dark:text-emerald-300';

    }


    function calculateDifference() {

        const selectedOption =
            productSelect.options[productSelect.selectedIndex];

        const systemQuantity =
            parseInt(selectedOption.dataset.quantity);

        const actualQuantity =
            parseInt(actualQuantityInput.value);


        if (isNaN(systemQuantity)) {

            systemQuantityText.textContent = '—';
            differenceText.textContent = '—';

            resetDifferenceStyles();

            return;

        }


        systemQuantityText.textContent =
            systemQuantity + ' gab.';


        if (isNaN(actualQuantity)) {

            differenceText.textContent = '—';

            resetDifferenceStyles();

            return;

        }


        const difference =
            actualQuantity - systemQuantity;


        if (difference > 0) {

            differenceText.textContent =
                '+' + difference + ' gab.';

            differenceBox.className =
                'rounded-xl border border-emerald-200 bg-emerald-50 p-5 transition dark:border-emerald-400/20 dark:bg-emerald-400/10';

            differenceLabel.className =
                'text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-600 dark:text-emerald-300';

            differenceText.className =
                'text-2xl font-bold text-emerald-700 dark:text-emerald-300';

        } else if (difference < 0) {

            differenceText.textContent =
                difference + ' gab.';

            differenceBox.className =
                'rounded-xl border border-red-200 bg-red-50 p-5 transition dark:border-red-400/20 dark:bg-red-400/10';

            differenceLabel.className =
                'text-[10px] font-bold uppercase tracking-[0.12em] text-red-600 dark:text-red-300';

            differenceText.className =
                'text-2xl font-bold text-red-700 dark:text-red-300';

        } else {

            differenceText.textContent = '0 gab.';

            differenceBox.className =
                'rounded-xl border border-slate-200 bg-slate-50 p-5 transition dark:border-emerald-400/10 dark:bg-emerald-400/[0.035]';

            differenceLabel.className =
                'text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400';

            differenceText.className =
                'text-2xl font-bold text-slate-900 dark:text-white';

        }

    }


    productSelect.addEventListener(
        'change',
        calculateDifference
    );

    actualQuantityInput.addEventListener(
        'input',
        calculateDifference
    );


    calculateDifference();

});
</script>

@endsection