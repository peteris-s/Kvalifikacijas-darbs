@extends('layouts.app')

@section('title', 'Preces | StockManager')

@section('page-title', 'Preces')

@section('content')

    <!-- TITLE -->
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">Preču katalogs</span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Preces
            </h1>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Noliktavas preču pārvaldība
            </p>
        </div>

        @if(auth()->user()->isAdmin())

            <a
                href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300">

                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                Pievienot preci
            </a>

        @endif

    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300">
            {{ session('success') }}
        </div>

    @endif


    <!-- ERROR MESSAGE -->
    @if(session('error'))

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 font-bold text-red-700 dark:bg-red-400/15 dark:text-red-300">
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
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <form
            method="GET"
            action="{{ route('products.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-4">

            <!-- SEARCH -->
            <div>

                <label
                    for="search"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">

                    Meklēt preci
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Preces nosaukums..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]">

            </div>


            <!-- CATEGORY FILTER -->
            <div>

                <label
                    for="category"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">

                    Kategorija
                </label>

                <select
                    id="category"
                    name="category"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]">

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
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">

                    Atlikuma statuss
                </label>

                <select
                    id="stock"
                    name="stock"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]">

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
                    class="flex-1 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-[#07110f] transition hover:bg-emerald-300">

                    Meklēt
                </button>

                <a
                    href="{{ route('products.index') }}"
                    class="rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:text-slate-300 dark:hover:border-emerald-400/40 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">

                    Notīrīt
                </a>

            </div>

        </form>

    </div>


    <!-- RESULT COUNT -->
    <div class="mb-4">

        <p class="text-sm text-slate-500 dark:text-slate-400">

            Atrastas preces:

            <span class="font-bold text-slate-800 dark:text-slate-200">
                {{ $products->count() }}
            </span>

        </p>

    </div>


    <!-- PRODUCTS TABLE -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

        <div class="overflow-x-auto">

            <table class="w-full">

                <!-- TABLE HEADER -->
                <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                    <tr class="text-left text-[11px] font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-500">

                        <th class="px-5 py-4">
                            Attēls
                        </th>

                        <th class="px-5 py-4">
                            Prece
                        </th>

                        <th class="px-5 py-4">
                            Kategorija
                        </th>

                        <th class="px-5 py-4">
                            Atrašanās vieta
                        </th>

                        <th class="px-5 py-4">
                            Cena
                        </th>

                        <th class="px-5 py-4">
                            Daudzums
                        </th>

                        <th class="px-5 py-4">
                            Min. daudzums
                        </th>

                        <th class="px-5 py-4">
                            Statuss
                        </th>

                        @if(auth()->user()->isAdmin())

                            <th class="px-5 py-4">
                                Darbības
                            </th>

                        @endif

                    </tr>

                </thead>


                <!-- TABLE BODY -->
                <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                @forelse($products as $product)

                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                        <!-- IMAGE -->
                        <td class="px-5 py-4">

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-14 w-14 rounded-xl border border-slate-200 object-cover dark:border-emerald-400/15">

                            @else

                                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-center text-[10px] font-medium text-slate-400 dark:bg-emerald-400/10 dark:text-slate-500">
                                    Nav attēla
                                </div>

                            @endif

                        </td>


                        <!-- PRODUCT NAME -->
                        <td class="px-5 py-4">

                            <p class="font-bold text-slate-900 dark:text-white">
                                {{ $product->name }}
                            </p>

                        </td>


                        <!-- CATEGORY -->
                        <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-400">

                            {{ $product->category->name ?? '-' }}

                        </td>


                        <!-- WAREHOUSE LOCATION -->
                        <td class="px-5 py-4">

                            @if($product->warehouseLocation)

                                <div>

                                    <p class="font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $product->warehouseLocation->parent?->name ?? 'Bez zonas' }}
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        → {{ $product->warehouseLocation->name }}
                                    </p>

                                </div>

                            @else

                                <span class="text-sm text-slate-400 dark:text-slate-500">
                                    Nav norādīta
                                </span>

                            @endif

                        </td>


                        <!-- PRICE -->
                        <td class="px-5 py-4 font-semibold text-slate-800 dark:text-slate-200">

                            €{{ number_format($product->price, 2) }}

                        </td>


                        <!-- QUANTITY -->
                        <td class="px-5 py-4">

                            <span class="font-bold text-slate-900 dark:text-white">
                                {{ $product->quantity }}
                            </span>

                        </td>


                        <!-- MINIMUM QUANTITY -->
                        <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-400">

                            {{ $product->minimum_quantity }}

                        </td>


                        <!-- STATUS -->
                        <td class="px-5 py-4">

                            @if($product->quantity <= $product->minimum_quantity)

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-100 px-3 py-1.5 text-xs font-bold text-orange-700 dark:bg-orange-400/10 dark:text-orange-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-orange-500"></span>
                                    Zems atlikums
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Pieejams
                                </span>

                            @endif

                        </td>


                        <!-- ADMIN ACTIONS -->
                        @if(auth()->user()->isAdmin())

                            <td class="px-5 py-4">

                                <div class="flex items-center gap-4">

                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-emerald-100 hover:text-emerald-700 dark:bg-white/[0.05] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">

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
                                            class="inline-flex rounded-lg px-3 py-2 text-xs font-bold text-red-500 transition hover:bg-red-50 hover:text-red-600 dark:text-red-400 dark:hover:bg-red-400/10 dark:hover:text-red-300">

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

                            <p class="font-semibold text-slate-600 dark:text-slate-300">
                                Neviena prece netika atrasta.
                            </p>


                            @if(request()->hasAny(['search', 'category', 'stock']))

                                <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
                                    Pamēģini mainīt meklēšanas vai filtra parametrus.
                                </p>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="mt-4 inline-block inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-emerald-100 hover:text-emerald-700 dark:bg-white/[0.05] dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300">

                                    Notīrīt filtrus
                                </a>

                            @else

                                @if(auth()->user()->isAdmin())

                                    <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
                                        Pievieno pirmo preci, lai sāktu noliktavas uzskaiti.
                                    </p>

                                    <a
                                        href="{{ route('products.create') }}"
                                        class="mt-5 inline-block inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300">

                                        + Pievienot preci
                                    </a>

                                @else

                                    <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">
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