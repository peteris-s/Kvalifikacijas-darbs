@extends('layouts.app')

@section('title', 'Rediģēt noliktavas vietu | StockManager')
@section('page-title', 'Noliktavas struktūra')

@section('content')

<div class="mx-auto max-w-3xl">

    <a
        href="{{ route('warehouse-locations.index') }}"
        class="text-sm font-medium text-blue-600 hover:underline">
        ← Atpakaļ uz noliktavas struktūru
    </a>


    <div class="mb-6 mt-3">

        <h1 class="text-3xl font-bold text-gray-800">
            Rediģēt noliktavas vietu
        </h1>

        <p class="mt-1 text-gray-500">
            Maini zonas vai plaukta informāciju.
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
        action="{{ route('warehouse-locations.update', $warehouseLocation) }}"
        class="rounded-xl bg-white p-8 shadow-sm">

        @csrf
        @method('PUT')


        <div class="mb-6">

            <label
                for="type"
                class="mb-2 block font-medium text-gray-700">
                Tips
            </label>

            <select
                id="type"
                name="type"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <option
                    value="zone"
                    @selected(old('type', $warehouseLocation->type) === 'zone')>
                    Zona
                </option>

                <option
                    value="shelf"
                    @selected(old('type', $warehouseLocation->type) === 'shelf')>
                    Plaukts
                </option>

            </select>

        </div>


        <div class="mb-6">

            <label
                for="name"
                class="mb-2 block font-medium text-gray-700">
                Nosaukums
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $warehouseLocation->name) }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

        </div>


        <div id="parent-container" class="mb-6">

            <label
                for="parent_id"
                class="mb-2 block font-medium text-gray-700">
                Zona
            </label>

            <select
                id="parent_id"
                name="parent_id"
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <option value="">
                    Izvēlies zonu
                </option>

                @foreach($parents as $parent)

                    <option
                        value="{{ $parent->id }}"
                        @selected(
                            old(
                                'parent_id',
                                $warehouseLocation->parent_id
                            ) == $parent->id
                        )>

                        {{ $parent->name }}

                    </option>

                @endforeach

            </select>

        </div>


        <div>

            <label
                for="description"
                class="mb-2 block font-medium text-gray-700">
                Apraksts
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full rounded-lg border border-gray-300 px-4 py-3">{{ old('description', $warehouseLocation->description) }}</textarea>

        </div>


        <div class="mt-8 flex justify-end gap-3 border-t pt-6">

            <a
                href="{{ route('warehouse-locations.index') }}"
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


<script>
document.addEventListener('DOMContentLoaded', function () {

    const type = document.getElementById('type');
    const parentContainer = document.getElementById('parent-container');
    const parentSelect = document.getElementById('parent_id');

    function updateForm() {

        if (type.value === 'shelf') {
            parentContainer.style.display = 'block';
            parentSelect.required = true;
        } else {
            parentContainer.style.display = 'none';
            parentSelect.required = false;
            parentSelect.value = '';
        }

    }

    type.addEventListener('change', updateForm);

    updateForm();

});
</script>

@endsection