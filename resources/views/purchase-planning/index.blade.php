@extends('layouts.app')

@section('title', 'Iepirkumu plānošana | StockManager')
@section('page-title', 'Iepirkumu plānošana')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Iepirkumu plānošana
    </h1>

    <p class="mt-1 text-gray-500">
        Automātiski izveidots saraksts ar precēm, kuru atlikums ir zem minimālā līmeņa.
    </p>

</div>


<div class="mb-6 grid gap-4 md:grid-cols-3">

    <!-- PRODUCTS TO ORDER -->
    <div class="rounded-xl bg-white p-6 shadow-sm">

        <p class="text-sm text-gray-500">
            Jāpasūta preces
        </p>

        <p class="mt-2 text-3xl font-bold text-gray-800">
            {{ $products->count() }}
        </p>

    </div>


    <!-- TOTAL QUANTITY -->
    <div class="rounded-xl bg-white p-6 shadow-sm">

        <p class="text-sm text-gray-500">
            Nepieciešamais daudzums
        </p>

        <p class="mt-2 text-3xl font-bold text-gray-800">

            {{ $products->sum(function ($product) {
                return $product->minimum_quantity - $product->quantity;
            }) }}

            <span class="text-base font-normal text-gray-500">
                gab.
            </span>

        </p>

    </div>


    <!-- STATUS -->
    <div class="rounded-xl bg-blue-50 p-6">

        <p class="text-sm text-blue-600">
            Statuss
        </p>

        @if($products->isNotEmpty())

            <p class="mt-2 text-lg font-semibold text-blue-800">
                Nepieciešams papildināt noliktavu
            </p>

        @else

            <p class="mt-2 text-lg font-semibold text-green-700">
                Noliktavas atlikumi ir pietiekami
            </p>

        @endif

    </div>

</div>


<!-- PURCHASE LIST -->
<div class="overflow-hidden rounded-xl bg-white shadow-sm">

    <div class="border-b px-6 py-5">

        <h2 class="text-lg font-semibold text-gray-800">
            Automātiski sagatavotais iepirkumu saraksts
        </h2>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b bg-gray-50">

                <tr class="text-left text-sm text-gray-600">

                    <th class="p-4">
                        Prece
                    </th>

                    <th class="p-4">
                        Kategorija
                    </th>

                    <th class="p-4">
                        Pašreizējais atlikums
                    </th>

                    <th class="p-4">
                        Minimālais atlikums
                    </th>

                    <th class="p-4">
                        Ieteicams pasūtīt
                    </th>

                    <th class="p-4">
                        Statuss
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($products as $product)

                    @php
                        $recommendedQuantity =
                            $product->minimum_quantity - $product->quantity;
                    @endphp

                    <tr class="border-b last:border-b-0 hover:bg-gray-50">

                        <!-- PRODUCT -->
                        <td class="p-4">

                            <div class="flex items-center gap-3">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-12 w-12 rounded-lg object-cover">

                                @else

                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                        Nav attēla
                                    </div>

                                @endif

                                <span class="font-semibold text-gray-800">
                                    {{ $product->name }}
                                </span>

                            </div>

                        </td>


                        <!-- CATEGORY -->
                        <td class="p-4 text-gray-600">

                            {{ $product->category->name ?? '-' }}

                        </td>


                        <!-- CURRENT QUANTITY -->
                        <td class="p-4">

                            <span class="font-semibold text-red-600">
                                {{ $product->quantity }} gab.
                            </span>

                        </td>


                        <!-- MINIMUM QUANTITY -->
                        <td class="p-4 text-gray-700">

                            {{ $product->minimum_quantity }} gab.

                        </td>


                        <!-- RECOMMENDED QUANTITY -->
                        <td class="p-4">

                            <span class="rounded-lg bg-blue-100 px-3 py-2 font-bold text-blue-700">
                                +{{ $recommendedQuantity }} gab.
                            </span>

                        </td>


                        <!-- STATUS -->
                        <td class="p-4">

                            @if($product->quantity == 0)

                                <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                    Nav noliktavā
                                </span>

                            @else

                                <span class="rounded-full bg-orange-100 px-3 py-1 text-sm font-semibold text-orange-700">
                                    Zems atlikums
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="p-12 text-center">

                            <p class="text-lg font-semibold text-green-700">
                                Visām precēm ir pietiekams atlikums.
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Pašlaik nav nepieciešams sagatavot iepirkumu.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection