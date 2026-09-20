@extends('layouts.app')

@section('title', 'Rediģēt preci | StockManager')
@section('page-title', 'Rediģēt preci')

@section('content')

<div class="mx-auto max-w-3xl">

    <a
        href="{{ route('products.index') }}"
        class="text-sm font-medium text-blue-600 hover:underline">
        ← Atpakaļ uz precēm
    </a>

    <div class="mb-6 mt-3">
        <h1 class="text-3xl font-bold text-gray-800">
            Rediģēt preci
        </h1>

        <p class="mt-1 text-gray-500">
            Maini preces informāciju un atrašanās vietu noliktavā.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 p-4 text-red-700">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('products.update', $product) }}"
        enctype="multipart/form-data"
        class="rounded-xl bg-white p-8 shadow-sm">

        @csrf
        @method('PUT')

        <div class="mb-6">
            <label
                for="name"
                class="mb-2 block font-medium text-gray-700">
                Preces nosaukums
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $product->name) }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">
        </div>

        <div class="mb-6">
            <label
                for="category_id"
                class="mb-2 block font-medium text-gray-700">
                Kategorija
            </label>

            <select
                id="category_id"
                name="category_id"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <option value="">
                    Izvēlies kategoriju
                </option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(
                            old('category_id', $product->category_id)
                            == $category->id
                        )>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-6">
            <label
                for="warehouse_location_id"
                class="mb-2 block font-medium text-gray-700">
                Noliktavas vieta
            </label>

            <select
                id="warehouse_location_id"
                name="warehouse_location_id"
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <option value="">
                    Nav norādīta
                </option>

                @foreach($warehouseLocations as $location)
                    <option
                        value="{{ $location->id }}"
                        @selected(
                            old(
                                'warehouse_location_id',
                                $product->warehouse_location_id
                            ) == $location->id
                        )>

                        {{ $location->parent?->name ?? 'Bez zonas' }}
                        → {{ $location->name }}

                    </option>
                @endforeach

            </select>

            <p class="mt-2 text-sm text-gray-500">
                Izvēlies konkrētu plauktu, kurā prece atrodas.
            </p>
        </div>

        <div class="mb-6 grid gap-6 md:grid-cols-2">

            <div>
                <label
                    for="price"
                    class="mb-2 block font-medium text-gray-700">
                    Cena (€)
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price', $product->price) }}"
                    min="0"
                    step="0.01"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>

            <div>
                <label
                    for="quantity"
                    class="mb-2 block font-medium text-gray-700">
                    Daudzums
                </label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="{{ old('quantity', $product->quantity) }}"
                    min="0"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>

        </div>

        <div class="mb-6">
            <label
                for="minimum_quantity"
                class="mb-2 block font-medium text-gray-700">
                Minimālais atlikums
            </label>

            <input
                type="number"
                id="minimum_quantity"
                name="minimum_quantity"
                value="{{ old('minimum_quantity', $product->minimum_quantity) }}"
                min="0"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">
        </div>

        <div class="mb-6">
            <label
                for="image"
                class="mb-2 block font-medium text-gray-700">
                Mainīt attēlu
            </label>

            @if($product->image)
                <div class="mb-4">
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="h-24 w-24 rounded-lg object-cover">
                </div>
            @endif

            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

            <p class="mt-2 text-sm text-gray-500">
                Ja nevēlies mainīt attēlu, atstāj šo lauku tukšu.
            </p>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t pt-6">

            <a
                href="{{ route('products.index') }}"
                class="rounded-lg border border-gray-300 px-5 py-3 font-medium text-gray-700 hover:bg-gray-50">
                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700">
                Saglabāt izmaiņas
            </button>

        </div>

    </form>

</div>

@endsection