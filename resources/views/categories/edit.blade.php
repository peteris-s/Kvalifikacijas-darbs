@extends('layouts.app')

@section('title', 'Rediģēt kategoriju | StockManager')

@section('page-title', 'Rediģēt kategoriju')

@section('content')

<div class="mx-auto max-w-3xl">

    <!-- BACK -->
    <a
        href="{{ route('categories.index') }}"
        class="text-sm font-medium text-blue-600 hover:underline">

        ← Atpakaļ uz kategorijām
    </a>


    <!-- TITLE -->
    <div class="mb-6 mt-3">

        <h1 class="text-3xl font-bold text-gray-800">
            Rediģēt kategoriju
        </h1>

        <p class="mt-1 text-gray-500">
            Maini kategorijas informāciju un tās atrašanās vietu hierarhijā.
        </p>

    </div>


    <!-- VALIDATION ERRORS -->
    @if($errors->any())

        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 p-4 text-red-700">

            <p class="font-semibold">
                Lūdzu pārbaudi ievadītos datus.
            </p>

            <ul class="mt-2 list-inside list-disc text-sm">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- FORM -->
    <form
        method="POST"
        action="{{ route('categories.update', $category) }}"
        class="rounded-xl bg-white p-8 shadow-sm">

        @csrf
        @method('PUT')


        <!-- CATEGORY NAME -->
        <div class="mb-6">

            <label
                for="name"
                class="mb-2 block font-medium text-gray-700">

                Kategorijas nosaukums
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

        </div>


        <!-- PARENT CATEGORY -->
        <div class="mb-6">

            <label
                for="parent_id"
                class="mb-2 block font-medium text-gray-700">

                Vecākkategorija
            </label>

            <select
                id="parent_id"
                name="parent_id"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">

                <option value="">
                    Nav — galvenā kategorija
                </option>

                @foreach($categories as $parentCategory)

                    <option
                        value="{{ $parentCategory->id }}"
                        @selected(
                            old('parent_id', $category->parent_id)
                            == $parentCategory->id
                        )>

                        @if($parentCategory->parent)
                            {{ $parentCategory->parent->name }} → {{ $parentCategory->name }}
                        @else
                            {{ $parentCategory->name }}
                        @endif

                    </option>

                @endforeach

            </select>

            <p class="mt-2 text-sm text-gray-400">
                Izvēlies kategoriju, zem kuras atradīsies šī kategorija.
            </p>

        </div>


        <!-- DESCRIPTION -->
        <div>

            <label
                for="description"
                class="mb-2 block font-medium text-gray-700">

                Apraksts
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Īss kategorijas apraksts..."
                class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-blue-500">{{ old('description', $category->description) }}</textarea>

            <p class="mt-2 text-sm text-gray-400">
                Apraksts nav obligāts.
            </p>

        </div>


        <!-- BUTTONS -->
        <div class="mt-8 flex justify-end gap-3">

            <a
                href="{{ route('categories.index') }}"
                class="rounded-lg border border-gray-300 px-5 py-3 font-medium text-gray-700 hover:bg-gray-50">

                Atcelt
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700">

                Saglabāt izmaiņas
            </button>

        </div>

    </form>

</div>

@endsection