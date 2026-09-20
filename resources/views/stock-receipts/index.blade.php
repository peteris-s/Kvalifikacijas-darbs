@extends('layouts.app')

@section('title', 'Preču saņemšana | StockManager')
@section('page-title', 'Preču saņemšana')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Preču saņemšana
        </h1>

        <p class="mt-1 text-gray-500">
            Saņemto preču pavadzīmes un to vēsture
        </p>
    </div>

    <a
        href="{{ route('stock-receipts.create') }}"
        class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">
        + Reģistrēt saņemšanu
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

                    <th class="p-4">
                        Pavadzīmes Nr.
                    </th>

                    <th class="p-4">
                        Preces
                    </th>

                    <th class="p-4">
                        Kopējais daudzums
                    </th>

                    <th class="p-4">
                        Saņemšanas datums
                    </th>

                    <th class="p-4">
                        Reģistrēja
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($documents as $document)

                    <tr class="border-b align-top last:border-b-0 hover:bg-gray-50">

                        <td class="p-4">

                            <span class="font-semibold text-gray-800">
                                {{ $document->document_number }}
                            </span>

                        </td>


                        <td class="p-4">

                            <div class="space-y-2">

                                @foreach($document->receipts as $receipt)

                                    <div class="flex items-center gap-2">

                                        <span class="text-gray-800">
                                            {{ $receipt->product->name ?? 'Dzēsta prece' }}
                                        </span>

                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                            +{{ $receipt->quantity }}
                                        </span>

                                    </div>

                                @endforeach

                            </div>

                        </td>


                        <td class="p-4">

                            <span class="font-semibold text-gray-800">
                                {{ $document->receipts->sum('quantity') }}
                            </span>

                            <span class="text-sm text-gray-500">
                                gab.
                            </span>

                        </td>


                        <td class="p-4 text-gray-600">

                            {{ $document->received_at->format('d.m.Y H:i') }}

                        </td>


                        <td class="p-4 text-gray-600">

                            {{ $document->user->name ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="p-12 text-center">

                            <p class="font-medium text-gray-600">
                                Pavadzīmes vēl nav reģistrētas.
                            </p>

                            <p class="mt-1 text-sm text-gray-400">
                                Reģistrē pirmo preču saņemšanu.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection