@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl">

    <!-- HEADER -->
    <div class="mb-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Reģistrēt preču izsniegšanu
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Reģistrē preces izsniegšanu klienta pasūtījuma izpildei.
                </p>
            </div>

            <a
                href="{{ route('stock-issues.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Atpakaļ
            </a>
        </div>
    </div>


    <!-- ERROR SUMMARY -->
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">
                Neizdevās reģistrēt izsniegšanu.
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
        action="{{ route('stock-issues.store') }}"
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
                    Norādi pasūtījumu, kuram prece tiek izsniegta.
                </p>
            </div>


            <!-- ORDER NUMBER -->
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
                    placeholder="Piemēram: ORD-1042"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Ievadi pasūtījuma numuru no interneta veikala.
                </p>
            </div>

        </div>


        <!-- PRODUCT -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Izsniedzamā prece
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Izvēlies preci un norādi izsniedzamo daudzumu.
                </p>
            </div>


            <div class="grid gap-6 md:grid-cols-2">

                <!-- PRODUCT SELECT -->
                <div>
                    <label
                        for="product_id"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Prece
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="product_id"
                        name="product_id"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >
                                {{ $product->name }}
                            </option>

                        @endforeach
                    </select>
                </div>


                <!-- QUANTITY -->
                <div>
                    <label
                        for="quantity"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Izsniedzamais daudzums
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity', 1) }}"
                        min="1"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

            </div>


            <!-- PRODUCT INFORMATION -->
            <div
                id="product-info"
                class="mt-6 hidden rounded-xl border border-gray-200 bg-gray-50 p-5"
            >

                <p class="mb-4 text-sm font-semibold text-gray-900">
                    Noliktavas informācija
                </p>

                <div class="grid gap-4 sm:grid-cols-3">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Pieejams
                        </p>

                        <p
                            id="available-quantity"
                            class="mt-1 text-xl font-bold text-gray-900"
                        >
                            -
                        </p>
                    </div>


                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Minimālais atlikums
                        </p>

                        <p
                            id="minimum-quantity"
                            class="mt-1 text-xl font-bold text-gray-900"
                        >
                            -
                        </p>
                    </div>


                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Atrašanās vieta
                        </p>

                        <p
                            id="product-location"
                            class="mt-1 font-semibold text-gray-900"
                        >
                            -
                        </p>
                    </div>

                </div>


                <!-- RESULT PREVIEW -->
                <div class="mt-5 border-t border-gray-200 pt-4">

                    <div class="flex items-center justify-between gap-4">

                        <span class="text-sm text-gray-500">
                            Atlikums pēc izsniegšanas
                        </span>

                        <span
                            id="remaining-quantity"
                            class="text-lg font-bold text-gray-900"
                        >
                            -
                        </span>

                    </div>

                    <p
                        id="quantity-warning"
                        class="mt-2 hidden text-sm font-medium text-red-600"
                    >
                        Noliktavā nav pietiekams preces daudzums.
                    </p>

                </div>

            </div>

        </div>


        <!-- NOTES -->
        <div class="rounded-xl bg-white p-6 shadow-sm">

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900">
                    Papildu informācija
                </h2>
            </div>

            <div>
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
                    placeholder="Piemēram: Klienta pasūtījums sagatavots nosūtīšanai."
                    class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >{{ old('notes') }}</textarea>
            </div>

        </div>


        <!-- SUBMIT -->
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('stock-issues.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-5 py-3 font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Atcelt
            </a>

            <button
                id="submit-button"
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                Izsniegt preci
            </button>

        </div>

    </form>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const productSelect =
            document.getElementById('product_id');

        const quantityInput =
            document.getElementById('quantity');

        const productInfo =
            document.getElementById('product-info');

        const availableQuantity =
            document.getElementById('available-quantity');

        const minimumQuantity =
            document.getElementById('minimum-quantity');

        const productLocation =
            document.getElementById('product-location');

        const remainingQuantity =
            document.getElementById('remaining-quantity');

        const quantityWarning =
            document.getElementById('quantity-warning');

        const submitButton =
            document.getElementById('submit-button');


        function updateProductInformation() {

            const selectedOption =
                productSelect.options[
                    productSelect.selectedIndex
                ];

            if (!selectedOption || !selectedOption.value) {
                productInfo.classList.add('hidden');
                submitButton.disabled = false;
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
                selectedOption.dataset.location || 'Nav norādīta';

            const issueQuantity =
                parseInt(quantityInput.value || 0);

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
                    'text-gray-900'
                );

                remainingQuantity.classList.add(
                    'text-red-600'
                );

                submitButton.disabled = true;

                submitButton.classList.add(
                    'cursor-not-allowed',
                    'opacity-50'
                );
            } else {
                quantityWarning.classList.add('hidden');

                remainingQuantity.classList.remove(
                    'text-red-600'
                );

                remainingQuantity.classList.add(
                    'text-gray-900'
                );

                submitButton.disabled = false;

                submitButton.classList.remove(
                    'cursor-not-allowed',
                    'opacity-50'
                );
            }
        }


        productSelect.addEventListener(
            'change',
            updateProductInformation
        );

        quantityInput.addEventListener(
            'input',
            updateProductInformation
        );


        updateProductInformation();

    });
</script>

@endsection