@extends('layouts.app')

@section('title', 'Noliktavas struktūra | StockManager')
@section('page-title', 'Noliktavas struktūra')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Noliktavas struktūra
        </h1>

        <p class="mt-1 text-gray-500">
            Pārvaldi noliktavas zonas un tajās esošos plauktus.
        </p>
    </div>

    <a
        href="{{ route('warehouse-locations.create') }}"
        class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">
        + Pievienot vietu
    </a>

</div>


@if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-100 px-5 py-4 text-green-700">
        {{ session('success') }}
    </div>
@endif


@if(session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-100 px-5 py-4 text-red-700">
        {{ session('error') }}
    </div>
@endif


@if($locations->isEmpty())

    <div class="rounded-xl bg-white p-12 text-center shadow-sm">

        <p class="text-lg font-semibold text-gray-700">
            Noliktavas struktūra vēl nav izveidota.
        </p>

        <p class="mt-2 text-gray-500">
            Izveido pirmo noliktavas zonu.
        </p>

    </div>

@else

    <div class="space-y-6">

        @foreach($locations as $location)

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <!-- ZONE -->
                <div class="flex items-center justify-between border-b bg-slate-50 p-6">

                    <div>

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-700">
                                Z
                            </div>

                            <div>
                                <h2 class="text-xl font-bold text-gray-800">
                                    {{ $location->name }}
                                </h2>

                                <p class="text-sm text-gray-500">
                                    Noliktavas zona
                                </p>
                            </div>

                        </div>

                        @if($location->description)
                            <p class="mt-3 text-sm text-gray-600">
                                {{ $location->description }}
                            </p>
                        @endif

                    </div>


                    <div class="flex gap-2">

                        <a
                            href="{{ route('warehouse-locations.edit', $location) }}"
                            class="rounded-lg bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-700 hover:bg-yellow-200">
                            Rediģēt
                        </a>

                        <form
                            method="POST"
                            action="{{ route('warehouse-locations.destroy', $location) }}"
                            onsubmit="return confirm('Vai tiešām vēlies dzēst šo zonu?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-lg bg-red-100 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-200">
                                Dzēst
                            </button>

                        </form>

                    </div>

                </div>


                <!-- SHELVES -->
                <div class="p-6">

                    <p class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                        Plaukti
                    </p>

                    @if($location->children->count() > 0)

                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                            @foreach($location->children as $child)

                                <div class="rounded-lg border border-gray-200 p-4">

                                    <div class="flex items-start justify-between gap-3">

                                        <div>

                                            <div class="flex items-center gap-2">

                                                <div class="flex h-8 w-8 items-center justify-center rounded bg-gray-100 text-sm font-bold text-gray-700">
                                                    P
                                                </div>

                                                <p class="font-semibold text-gray-800">
                                                    {{ $child->name }}
                                                </p>

                                            </div>

                                            @if($child->description)
                                                <p class="mt-2 text-sm text-gray-500">
                                                    {{ $child->description }}
                                                </p>
                                            @endif

                                        </div>


                                        <div class="flex gap-1">

                                            <a
                                                href="{{ route('warehouse-locations.edit', $child) }}"
                                                class="rounded px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-50">
                                                Rediģēt
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('warehouse-locations.destroy', $child) }}"
                                                onsubmit="return confirm('Vai tiešām vēlies dzēst šo plauktu?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded px-2 py-1 text-sm font-medium text-red-600 hover:bg-red-50">
                                                    Dzēst
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="text-sm text-gray-400">
                            Šajā zonā vēl nav izveidoti plaukti.
                        </p>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection