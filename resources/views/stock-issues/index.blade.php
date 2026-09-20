@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- HEADER -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Preču izsniegšana
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Reģistrē un apskati no noliktavas izsniegtās preces.
            </p>
        </div>

        <a
            href="{{ route('stock-issues.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
        >
            + Reģistrēt izsniegšanu
        </a>

    </div>


    <!-- SUCCESS MESSAGE -->
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <!-- INFORMATION -->
    <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-5">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="font-semibold text-blue-900">
                    Izsniegšanas vēsture
                </p>

                <p class="mt-1 text-sm text-blue-700">
                    Katrs ieraksts parāda, kuram pasūtījumam prece tika izsniegta un kurš darbinieks veica izsniegšanu.
                </p>
            </div>

            <div class="shrink-0 rounded-lg bg-white px-4 py-2 text-center shadow-sm">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Izsniegšanas
                </p>

                <p class="mt-1 text-xl font-bold text-gray-900">
                    {{ $stockIssues->count() }}
                </p>
            </div>

        </div>

    </div>


    <!-- TABLE -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Pasūtījums
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Prece
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Daudzums
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Izsniedza
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Datums
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Piezīmes
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($stockIssues as $issue)

                        <tr class="transition hover:bg-gray-50">

                            <!-- ORDER -->
                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                                    {{ $issue->order_number }}
                                </span>

                            </td>


                            <!-- PRODUCT -->
                            <td class="px-6 py-4">

                                <p class="font-semibold text-gray-900">
                                    {{ $issue->product->name }}
                                </p>

                                @if ($issue->product->category)

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $issue->product->category->name }}
                                    </p>

                                @endif

                            </td>


                            <!-- QUANTITY -->
                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="inline-flex rounded-lg bg-red-50 px-3 py-1 text-sm font-semibold text-red-700">
                                    -{{ $issue->quantity }} gab.
                                </span>

                            </td>


                            <!-- USER -->
                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="text-sm font-medium text-gray-900">
                                    {{ $issue->user->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $issue->user->isAdmin() ? 'Administrators' : 'Darbinieks' }}
                                </p>

                            </td>


                            <!-- DATE -->
                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="text-sm text-gray-900">
                                    {{ $issue->issued_at->format('d.m.Y') }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $issue->issued_at->format('H:i') }}
                                </p>

                            </td>


                            <!-- NOTES -->
                            <td class="max-w-xs px-6 py-4">

                                @if ($issue->notes)

                                    <p class="text-sm text-gray-600">
                                        {{ $issue->notes }}
                                    </p>

                                @else

                                    <span class="text-sm text-gray-400">
                                        Nav piezīmju
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto max-w-md">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl">
                                        📦
                                    </div>

                                    <h3 class="mt-4 font-semibold text-gray-900">
                                        Nav reģistrētu izsniegšanu
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Kad prece tiks izsniegta klienta pasūtījumam, ieraksts parādīsies šeit.
                                    </p>

                                    <a
                                        href="{{ route('stock-issues.create') }}"
                                        class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Reģistrēt pirmo izsniegšanu
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection