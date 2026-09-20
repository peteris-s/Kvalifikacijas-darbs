@extends('layouts.app')

@section('title', 'Atskaites | StockManager')
@section('page-title', 'Atskaites')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Atskaites
        </h1>

        <p class="mt-1 text-gray-500">
            Izvēlies atskaites veidu un nepieciešamo laika periodu.
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
        method="GET"
        action="{{ route('reports.preview') }}"
        class="rounded-xl bg-white p-8 shadow-sm">

        <!-- REPORT TYPE -->
        <div class="mb-6">

            <label
                for="report_type"
                class="mb-2 block font-medium text-gray-700">
                Atskaites veids
            </label>

            <select
                id="report_type"
                name="report_type"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-3">

                <option value="">
                    Izvēlies atskaites veidu
                </option>

                <option
                    value="stock"
                    @selected(request('report_type') === 'stock')>
                    Preču atlikumu atskaite
                </option>

                <option
                    value="receipts"
                    @selected(request('report_type') === 'receipts')>
                    Preču saņemšanas atskaite
                </option>

                <option
                    value="inventory"
                    @selected(request('report_type') === 'inventory')>
                    Inventarizācijas atskaite
                </option>

            </select>

        </div>


        <!-- DATE PERIOD -->
        <div
            id="date-period"
            class="mb-6">

            <p class="mb-3 font-medium text-gray-700">
                Laika periods
            </p>

            <div class="grid gap-4 md:grid-cols-2">

                <div>

                    <label
                        for="date_from"
                        class="mb-2 block text-sm text-gray-600">
                        No
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">

                </div>


                <div>

                    <label
                        for="date_to"
                        class="mb-2 block text-sm text-gray-600">
                        Līdz
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3">

                </div>

            </div>

            <p class="mt-2 text-sm text-gray-500">
                Preču atlikumu atskaitei periods nav nepieciešams.
            </p>

        </div>


        <div class="flex justify-end border-t pt-6">

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition hover:bg-blue-700">
                Ģenerēt atskaiti
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const reportType =
        document.getElementById('report_type');

    const datePeriod =
        document.getElementById('date-period');


    function updateDateFields() {

        if (reportType.value === 'stock') {

            datePeriod.style.display = 'none';

        } else {

            datePeriod.style.display = 'block';

        }

    }


    reportType.addEventListener(
        'change',
        updateDateFields
    );

    updateDateFields();

});

</script>

@endsection