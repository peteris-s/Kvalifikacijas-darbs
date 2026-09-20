@extends('layouts.app')

@section('title', 'Preces | StockManager')

@section('page-title', 'Preces')

@section('content')

    <!-- TITLE -->
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Preces
            </h1>

            <p class="mt-1 text-gray-500">
                Noliktavas preču pārvaldība
            </p>
        </div>

        @if(auth()->user()->isAdmin())

            <a
                href="{{ route('products.create') }}"
                class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700">

                + Pievienot preci
            </a>

        @endif

    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <!-- ERROR MESSAGE -->
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 px-5 py-4 text-red-700">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-200 font-bold text-red-700">
                    !
                </div>

                <div>
                    <p class="font-semibold">
                        Preci neizdevās izdzēst
                    </p>

                    <p class="mt-1 text-sm">
                        {{ session('error') }}
                    </p>
                </div>

            </div>

        </div>

    @endif


    <!-- SEARCH AND FILTERS -->
    <div class="mb-6 rounded-xl bg-white p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('products.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-4">

            <!-- SEARCH -->
            <div>

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium text-gray-700">

                    Meklēt preci
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Preces nosaukums..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

            </div>


            <!-- CATEGORY FILTER -->
            <div>

                <label
                    for="category"
                    class="mb-2 block text-sm font-medium text-gray-700">

                    Kategorija
                </label>

                <select
                    id="category"
                    name="category"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                    <option value="">
                        Visas kategorijas
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(request('category') == $category->id)>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            <!-- STOCK FILTER -->
            <div>

                <label
                    for="stock"
                    class="mb-2 block text-sm font-medium text-gray-700">

                    Atlikuma statuss
                </label>

                <select
                    id="stock"
                    name="stock"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                    <option value="">
                        Visi
                    </option>

                    <option
                        value="available"
                        @selected(request('stock') === 'available')>

                        Pieejams
                    </option>

                    <option
                        value="low"
                        @selected(request('stock') === 'low')>

                        Zems atlikums
                    </option>

                </select>

            </div>


            <!-- FILTER BUTTONS -->
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white hover:bg-blue-700">

                    Meklēt
                </button>

                <a
                    href="{{ route('products.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-3 font-medium text-gray-600 hover:bg-gray-50">

                    Notīrīt
                </a>

            </div>

        </form>

    </div>


    <!-- RESULT COUNT -->
    <div class="mb-4">

        <p class="text-sm text-gray-500">

            Atrastas preces:

            <span class="font-semibold text-gray-700">
                {{ $products->count() }}
            </span>

        </p>

    </div>


    <!-- PRODUCTS TABLE -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full">

                <!-- TABLE HEADER -->
                <thead class="border-b bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">

                        <th class="p-4">
                            Attēls
                        </th>

                        <th class="p-4">
                            Prece
                        </th>

                        <th class="p-4">
                            Kategorija
                        </th>

                        <th class="p-4">
                            Atrašanās vieta
                        </th>

                        <th class="p-4">
                            Cena
                        </th>

                        <th class="p-4">
                            Daudzums
                        </th>

                        <th class="p-4">
                            Min. daudzums
                        </th>

                        <th class="p-4">
                            Statuss
                        </th>

                        @if(auth()->user()->isAdmin())

                            <th class="p-4">
                                Darbības
                            </th>

                        @endif

                    </tr>

                </thead>


                <!-- TABLE BODY -->
                <tbody>

                @forelse($products as $product)

                    <tr class="border-b last:border-b-0 hover:bg-gray-50">

                        <!-- IMAGE -->
                        <td class="p-4">

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-14 w-14 rounded-lg object-cover">

                            @else

                                <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-gray-200 text-center text-xs text-gray-500">
                                    Nav attēla
                                </div>

                            @endif

                        </td>


                        <!-- PRODUCT NAME -->
                        <td class="p-4">

                            <p class="font-semibold text-gray-800">
                                {{ $product->name }}
                            </p>

                        </td>


                        <!-- CATEGORY -->
                        <td class="p-4 text-gray-600">

                            {{ $product->category->name ?? '-' }}

                        </td>


                        <!-- WAREHOUSE LOCATION -->
                        <td class="p-4">

                            @if($product->warehouseLocation)

                                <div>

                                    <p class="font-medium text-gray-800">
                                        {{ $product->warehouseLocation->parent?->name ?? 'Bez zonas' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        → {{ $product->warehouseLocation->name }}
                                    </p>

                                </div>

                            @else

                                <span class="text-sm text-gray-400">
                                    Nav norādīta
                                </span>

                            @endif

                        </td>


                        <!-- PRICE -->
                        <td class="p-4 font-medium text-gray-800">

                            €{{ number_format($product->price, 2) }}

                        </td>


                        <!-- QUANTITY -->
                        <td class="p-4">

                            <span class="font-semibold text-gray-800">
                                {{ $product->quantity }}
                            </span>

                        </td>


                        <!-- MINIMUM QUANTITY -->
                        <td class="p-4 text-gray-600">

                            {{ $product->minimum_quantity }}

                        </td>


                        <!-- STATUS -->
                        <td class="p-4">

                            @if($product->quantity <= $product->minimum_quantity)

                                <span class="inline-block rounded-full bg-orange-100 px-3 py-1 text-sm font-medium text-orange-700">
                                    Zems atlikums
                                </span>

                            @else

                                <span class="inline-block rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700">
                                    Pieejams
                                </span>

                            @endif

                        </td>


                        <!-- ADMIN ACTIONS -->
                        @if(auth()->user()->isAdmin())

                            <td class="p-4">

                                <div class="flex items-center gap-4">

                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="font-medium text-blue-600 hover:underline">

                                        Rediģēt
                                    </a>


                                    <!-- DELETE -->
                                    <form
                                        method="POST"
                                        action="{{ route('products.destroy', $product) }}"
                                        onsubmit="return confirm('Vai tiešām vēlies dzēst preci {{ $product->name }}?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="font-medium text-red-600 hover:underline">

                                            Dzēst
                                        </button>

                                    </form>

                                </div>

                            </td>

                        @endif

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="{{ auth()->user()->isAdmin() ? 9 : 8 }}"
                            class="p-12 text-center">

                            <p class="font-medium text-gray-600">
                                Neviena prece netika atrasta.
                            </p>


                            @if(request()->hasAny(['search', 'category', 'stock']))

                                <p class="mt-1 text-sm text-gray-400">
                                    Pamēģini mainīt meklēšanas vai filtra parametrus.
                                </p>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="mt-4 inline-block font-medium text-blue-600 hover:underline">

                                    Notīrīt filtrus
                                </a>

                            @else

                                @if(auth()->user()->isAdmin())

                                    <p class="mt-1 text-sm text-gray-400">
                                        Pievieno pirmo preci, lai sāktu noliktavas uzskaiti.
                                    </p>

                                    <a
                                        href="{{ route('products.create') }}"
                                        class="mt-5 inline-block rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700">

                                        + Pievienot preci
                                    </a>

                                @else

                                    <p class="mt-1 text-sm text-gray-400">
                                        Noliktavā pašlaik nav reģistrētu preču.
                                    </p>

                                @endif

                            @endif

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection