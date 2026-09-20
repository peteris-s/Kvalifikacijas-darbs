@extends('layouts.app')

@section('title', 'Jauna inventarizācija | StockManager')
@section('page-title', 'Inventarizācija')

@section('content')

<div class="mx-auto max-w-3xl">

    <a
        href="{{ route('inventory-adjustments.index') }}"
        class="text-sm font-medium text-blue-600 hover:underline">
        ← Atpakaļ uz inventarizāciju
    </a>


    <div class="mb-6 mt-3">

        <h1 class="text-3xl font-bold text-gray-800">
            Jauna inventarizācija
        </h1>

        <p class="mt-1 text-gray-500">
            Ievadi faktiski saskaitīto preces daudzumu noliktavā.
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
        action="{{ route('inventory-adjustments.store') }}"
        class="rounded-xl bg-white p-8 shadow-sm">

        @csrf


        <!-- PRODUCT -->
        <div class="mb-6">

            <label
                for="product_id"
                class="mb-2 block font-medium text-gray-700">
                Prece
            </label>

            <select
                id="product_id"
                name="product_id"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                <option value="">
                    Izvēlies preci
                </option>

                @foreach($products as $product)

                    <option
                        value="{{ $product->id }}"
                        data-quantity="{{ $product->quantity }}"
                        @selected(old('product_id') == $product->id)>

                        {{ $product->name }} — sistēmā: {{ $product->quantity }} gab.

                    </option>

                @endforeach

            </select>

        </div>


        <!-- CURRENT QUANTITY -->
        <div class="mb-6 rounded-lg bg-gray-50 p-5">

            <p class="text-sm text-gray-500">
                Pašreizējais atlikums sistēmā
            </p>

            <p
                id="system-quantity"
                class="mt-1 text-2xl font-bold text-gray-800">
                —
            </p>

        </div>


        <!-- ACTUAL QUANTITY -->
        <div class="mb-6">

            <label
                for="actual_quantity"
                class="mb-2 block font-medium text-gray-700">
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
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

        </div>


        <!-- DIFFERENCE -->
        <div class="mb-6 rounded-lg border border-blue-100 bg-blue-50 p-5">

            <p class="text-sm text-blue-600">
                Aprēķinātā starpība
            </p>

            <p
                id="difference"
                class="mt-1 text-2xl font-bold text-blue-700">
                —
            </p>

        </div>


        <!-- REASON -->
        <div class="mb-6">

            <label
                for="reason"
                class="mb-2 block font-medium text-gray-700">
                Korekcijas iemesls
            </label>

            <select
                id="reason"
                name="reason"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

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
                class="mb-2 block font-medium text-gray-700">
                Piezīmes
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="4"
                placeholder="Papildu informācija par korekciju..."
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">{{ old('notes') }}</textarea>

        </div>


        <!-- DATE -->
        <div>

            <label
                for="adjusted_at"
                class="mb-2 block font-medium text-gray-700">
                Inventarizācijas datums un laiks
            </label>

            <input
                type="datetime-local"
                id="adjusted_at"
                name="adjusted_at"
                value="{{ old('adjusted_at', now()->format('Y-m-d\TH:i')) }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

        </div>


        <div class="mt-8 flex justify-end gap-3 border-t pt-6">

            <a
                href="{{ route('inventory-adjustments.index') }}"
                class="rounded-lg border border-gray-300 px-5 py-3 font-medium text-gray-700 hover:bg-gray-50">
                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700">
                Reģistrēt korekciju
            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const productSelect = document.getElementById('product_id');
    const actualQuantityInput = document.getElementById('actual_quantity');

    const systemQuantityText = document.getElementById('system-quantity');
    const differenceText = document.getElementById('difference');


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
            return;
        }

        systemQuantityText.textContent =
            systemQuantity + ' gab.';


        if (isNaN(actualQuantity)) {
            differenceText.textContent = '—';
            return;
        }


        const difference =
            actualQuantity - systemQuantity;


        if (difference > 0) {
            differenceText.textContent =
                '+' + difference + ' gab.';
        }
        else {
            differenceText.textContent =
                difference + ' gab.';
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