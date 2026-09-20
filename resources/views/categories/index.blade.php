@extends('layouts.app')

@section('title', 'Kategorijas | StockManager')

@section('page-title', 'Kategorijas')

@section('content')

    <!-- TITLE -->
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Kategorijas
            </h1>

            <p class="mt-1 text-gray-500">
                Preču kategoriju hierarhiskā pārvaldība
            </p>
        </div>

        <a
            href="{{ route('categories.create') }}"
            class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700">

            + Pievienot kategoriju
        </a>

    </div>


    <!-- SUCCESS -->
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <!-- ERROR -->
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 px-5 py-4 text-red-700">
            {{ session('error') }}
        </div>

    @endif


    <!-- TABLE -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b bg-gray-50">

                    <tr class="text-left text-sm text-gray-600">

                        <th class="p-4">
                            Kategorija
                        </th>

                        <th class="p-4">
                            Vecākkategorija
                        </th>

                        <th class="p-4">
                            Apraksts
                        </th>

                        <th class="p-4">
                            Preču skaits
                        </th>

                        <th class="p-4">
                            Apakškategorijas
                        </th>

                        <th class="p-4">
                            Darbības
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($categories as $category)

                        @php
                            $level = 0;
                            $currentParent = $category->parent;

                            while ($currentParent) {
                                $level++;
                                $currentParent = $currentParent->parent;
                            }
                        @endphp


                        <tr class="border-b last:border-b-0 hover:bg-gray-50">

                            <!-- CATEGORY -->
                            <td class="p-4">

                                <div
                                    class="flex items-center"
                                    style="padding-left: {{ $level * 28 }}px;">

                                    @if($level > 0)

                                        <span class="mr-2 text-lg text-gray-400">
                                            ↳
                                        </span>

                                    @endif


                                    <div>

                                        <p class="font-semibold text-gray-800">
                                            {{ $category->name }}
                                        </p>


                                        @if($level === 0)

                                            <span class="mt-1 inline-block rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
                                                Galvenā kategorija
                                            </span>

                                        @else

                                            <span class="mt-1 inline-block rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">
                                                {{ $level }}. līmeņa apakškategorija
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <!-- PARENT -->
                            <td class="p-4">

                                @if($category->parent)

                                    <span class="font-medium text-gray-700">
                                        {{ $category->parent->name }}
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- DESCRIPTION -->
                            <td class="p-4 text-gray-600">

                                @if($category->description)

                                    {{ $category->description }}

                                @else

                                    <span class="text-gray-400">
                                        Nav apraksta
                                    </span>

                                @endif

                            </td>


                            <!-- PRODUCT COUNT -->
                            <td class="p-4">

                                <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">
                                    {{ $category->products_count }}
                                </span>

                            </td>


                            <!-- CHILD CATEGORY COUNT -->
                            <td class="p-4">

                                @if($category->children_count > 0)

                                    <span class="inline-block rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-700">
                                        {{ $category->children_count }}
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        0
                                    </span>

                                @endif

                            </td>


                            <!-- ACTIONS -->
                            <td class="p-4">

                                <div class="flex items-center gap-4">

                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="font-medium text-blue-600 hover:underline">

                                        Rediģēt
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('categories.destroy', $category) }}"
                                        onsubmit="return confirm('Vai tiešām vēlies dzēst kategoriju {{ $category->name }}?');">

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

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="p-12 text-center">

                                <p class="font-medium text-gray-600">
                                    Nav izveidota neviena kategorija.
                                </p>

                                <p class="mt-1 text-sm text-gray-400">
                                    Izveido pirmo kategoriju preču organizēšanai.
                                </p>

                                <a
                                    href="{{ route('categories.create') }}"
                                    class="mt-5 inline-block rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700">

                                    + Pievienot kategoriju
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection