@extends('layouts.app')

@section('title', 'Iepirkumu plānošana | StockManager')
@section('page-title', 'Iepirkumu plānošana')

@section('content')

<!-- HEADER -->
<div class="mb-8">

    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

        <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
            Automātiska papildināšana
        </span>
    </div>

    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
        Iepirkumu plānošana
    </h1>

    <p class="mt-2 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
        Automātiski izveidots saraksts ar precēm, kuru atlikums ir sasniedzis minimālo līmeni.
    </p>

</div>


<!-- STATISTICS -->
<div class="mb-6 grid gap-4 md:grid-cols-3">

    <!-- PRODUCTS TO ORDER -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-300 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-emerald-400/30">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                    Jāpasūta preces
                </p>

                <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">
                    {{ $products->count() }}
                </p>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Preču pozīcijas
                </p>

            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                    <path d="M3 6h18"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>

            </div>

        </div>

    </div>


    <!-- TOTAL QUANTITY -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-300 dark:border-emerald-400/15 dark:bg-[#0d1b18] dark:hover:border-emerald-400/30">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-400 dark:text-slate-500">
                    Nepieciešamais daudzums
                </p>

                <div class="mt-3 flex items-end gap-2">

                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                        {{ $products->sum(function ($product) {
                            return $product->minimum_quantity - $product->quantity;
                        }) }}
                    </p>

                    <span class="mb-1 text-sm font-medium text-slate-400 dark:text-slate-500">
                        gab.
                    </span>

                </div>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Kopā nepieciešams pasūtīt
                </p>

            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M12 20V10"/>
                    <path d="m18 16-6-6-6 6"/>
                    <path d="M5 4h14"/>
                </svg>

            </div>

        </div>

    </div>


    <!-- STATUS -->
    @if($products->isNotEmpty())

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm dark:border-amber-400/20 dark:bg-amber-400/[0.08]">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-xs font-bold uppercase tracking-[0.1em] text-amber-600 dark:text-amber-300">
                        Statuss
                    </p>

                    <p class="mt-3 text-lg font-bold leading-snug text-amber-800 dark:text-amber-200">
                        Nepieciešams papildināt noliktavu
                    </p>

                    <p class="mt-1 text-xs text-amber-700/70 dark:text-amber-300/70">
                        Ir preces ar zemu atlikumu
                    </p>

                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-400/10 dark:text-amber-300">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M10.3 2.9 1.8 17a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 2.9a2 2 0 0 0-3.4 0Z"/>
                        <path d="M12 9v4"/>
                        <path d="M12 17h.01"/>
                    </svg>

                </div>

            </div>

        </div>

    @else

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm dark:border-emerald-400/20 dark:bg-emerald-400/[0.08]">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-xs font-bold uppercase tracking-[0.1em] text-emerald-600 dark:text-emerald-300">
                        Statuss
                    </p>

                    <p class="mt-3 text-lg font-bold leading-snug text-emerald-800 dark:text-emerald-200">
                        Noliktavas atlikumi ir pietiekami
                    </p>

                    <p class="mt-1 text-xs text-emerald-700/70 dark:text-emerald-300/70">
                        Papildināšana pašlaik nav nepieciešama
                    </p>

                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="m5 12 4 4L19 6"/>
                    </svg>

                </div>

            </div>

        </div>

    @endif

</div>


<!-- PURCHASE LIST -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

    <!-- CARD HEADER -->
    <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="font-bold text-slate-900 dark:text-white">
                Automātiski sagatavotais iepirkumu saraksts
            </h2>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Aprēķins balstīts uz pašreizējo un minimālo preču atlikumu
            </p>

        </div>

        @if($products->isNotEmpty())

            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">

                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                {{ $products->count() }} jāpapildina

            </span>

        @else

            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">

                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                Viss kārtībā

            </span>

        @endif

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b border-slate-100 bg-slate-50/80 dark:border-emerald-400/10 dark:bg-emerald-400/[0.04]">

                <tr class="text-left text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500">

                    <th class="px-6 py-3">
                        Prece
                    </th>

                    <th class="px-6 py-3">
                        Kategorija
                    </th>

                    <th class="px-6 py-3">
                        Pašreizējais
                    </th>

                    <th class="px-6 py-3">
                        Minimums
                    </th>

                    <th class="px-6 py-3">
                        Ieteicams pasūtīt
                    </th>

                    <th class="px-6 py-3">
                        Statuss
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 dark:divide-emerald-400/10">

                @forelse($products as $product)

                    @php
                        $recommendedQuantity =
                            $product->minimum_quantity - $product->quantity;
                    @endphp


                    <tr class="transition hover:bg-slate-50/70 dark:hover:bg-emerald-400/[0.04]">

                        <!-- PRODUCT -->
                        <td class="px-6 py-5">

                            <div class="flex min-w-[220px] items-center gap-3">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-12 w-12 rounded-xl border border-slate-200 object-cover dark:border-emerald-400/10"
                                    >

                                @else

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-emerald-400/[0.06] dark:text-slate-500">

                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                                            <path d="m3.3 7 8.7 5 8.7-5"/>
                                        </svg>

                                    </div>

                                @endif


                                <div>

                                    <p class="font-bold text-slate-900 dark:text-white">
                                        {{ $product->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                        Preces ID: #{{ $product->id }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        <!-- CATEGORY -->
                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-white/[0.05] dark:text-slate-300">
                                {{ $product->category->name ?? '-' }}
                            </span>

                        </td>


                        <!-- CURRENT QUANTITY -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-2">

                                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                <span class="font-bold text-red-600 dark:text-red-300">
                                    {{ $product->quantity }} gab.
                                </span>

                            </div>

                        </td>


                        <!-- MINIMUM -->
                        <td class="px-6 py-5">

                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                {{ $product->minimum_quantity }} gab.
                            </span>

                        </td>


                        <!-- RECOMMENDED -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-100 px-3 py-2 text-sm font-bold text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">

                                <svg
                                    class="h-3.5 w-3.5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path d="M12 5v14"/>
                                    <path d="M5 12h14"/>
                                </svg>

                                {{ $recommendedQuantity }} gab.

                            </span>

                        </td>


                        <!-- STATUS -->
                        <td class="px-6 py-5">

                            @if($product->quantity == 0)

                                <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 dark:bg-red-400/10 dark:text-red-300">

                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                    Nav noliktavā

                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-400/10 dark:text-amber-300">

                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                    Zems atlikums

                                </span>

                            @endif

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="6" class="px-6 py-16 text-center">

                            <div class="mx-auto max-w-md">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path d="m5 12 4 4L19 6"/>
                                    </svg>

                                </div>

                                <h3 class="mt-4 font-bold text-slate-900 dark:text-white">
                                    Noliktavas atlikumi ir pietiekami
                                </h3>

                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                    Pašlaik nevienai precei nav nepieciešama papildināšana.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection