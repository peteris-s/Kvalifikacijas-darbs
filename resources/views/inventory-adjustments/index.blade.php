@extends('layouts.app')

@section('title', 'Inventarizācija | StockManager')
@section('page-title', 'Inventarizācija')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Inventarizācija
        </h1>

        <p class="mt-1 text-gray-500">
            Inventarizācijas starpību un atlikumu korekciju vēsture
        </p>
    </div>

    <a
        href="{{ route('inventory-adjustments.create') }}"
        class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">
        + Jauna inventarizācija
    </a>

</div>


@if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-100 px-5 py-4 text-green-700">
        {{ session('success') }}
    </div>
@endif


<div class="overflow-hidden rounded-xl bg-white shadow-sm">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="border-b bg-gray-50">

                <tr class="text-left text-sm text-gray-600">
                    <th class="p-4">Prece</th>
                    <th class="p-4">Sistēmā bija</th>
                    <th class="p-4">Faktiski</th>
                    <th class="p-4">Starpība</th>
                    <th class="p-4">Iemesls</th>
                    <th class="p-4">Datums</th>
                    <th class="p-4">Veica</th>
                </tr>

            </thead>

            <tbody>

                @forelse($adjustments as $adjustment)

                    <tr class="border-b last:border-b-0 hover:bg-gray-50">

                        <td class="p-4 font-semibold text-gray-800">
                            {{ $adjustment->product->name ?? 'Dzēsta prece' }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $adjustment->system_quantity }} gab.
                        </td>

                        <td class="p-4 font-medium text-gray-800">
                            {{ $adjustment->actual_quantity }} gab.
                        </td>

                        <td class="p-4">

                            @if($adjustment->difference > 0)

                                <span class="rounded bg-green-100 px-2 py-1 font-semibold text-green-700">
                                    +{{ $adjustment->difference }}
                                </span>

                            @elseif($adjustment->difference < 0)

                                <span class="rounded bg-red-100 px-2 py-1 font-semibold text-red-700">
                                    {{ $adjustment->difference }}
                                </span>

                            @else

                                <span class="rounded bg-gray-100 px-2 py-1 font-semibold text-gray-600">
                                    0
                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <p class="font-medium text-gray-800">
                                {{ $adjustment->reason }}
                            </p>

                            @if($adjustment->notes)
                                <p class="mt-1 max-w-xs text-sm text-gray-500">
                                    {{ $adjustment->notes }}
                                </p>
                            @endif

                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $adjustment->adjusted_at->format('d.m.Y H:i') }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $adjustment->user->name ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="p-12 text-center">

                            <p class="font-medium text-gray-600">
                                Inventarizācijas ierakstu vēl nav.
                            </p>

                            <p class="mt-1 text-sm text-gray-400">
                                Veic pirmo noliktavas inventarizāciju.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection