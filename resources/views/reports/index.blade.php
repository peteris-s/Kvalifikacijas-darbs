@extends('layouts.app')

@section('title', 'Atskaites | StockManager')
@section('page-title', 'Atskaites')

@section('content')

<div class="mx-auto max-w-4xl">

    <!-- HEADER -->
    <div class="mb-8">

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Datu pārskati
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Atskaites
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Izvēlies atskaites veidu un nepieciešamo laika periodu.
        </p>

    </div>


    <!-- ERRORS -->
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 text-red-700 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-400/10">

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v4"/>
                        <path d="M12 16h.01"/>
                    </svg>

                </div>

                <div>

                    <p class="font-bold">
                        Lūdzu pārbaudi ievadītos datus.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <!-- REPORT TYPE INFO CARDS -->
    <div class="mb-6 grid gap-4 md:grid-cols-3">

        <!-- STOCK -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>

            </div>

            <h3 class="font-bold text-slate-900 dark:text-white">
                Preču atlikumi
            </h3>

            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                Pašreizējais noliktavas preču atlikumu pārskats.
            </p>

        </div>


        <!-- RECEIPTS -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M12 3v12"/>
                    <path d="m7 10 5 5 5-5"/>
                    <path d="M5 21h14"/>
                </svg>

            </div>

            <h3 class="font-bold text-slate-900 dark:text-white">
                Preču saņemšana
            </h3>

            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                Noliktavā saņemto preču pārskats izvēlētā periodā.
            </p>

        </div>


        <!-- INVENTORY -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]">

            <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>

            </div>

            <h3 class="font-bold text-slate-900 dark:text-white">
                Inventarizācija
            </h3>

            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                Atlikumu korekciju un inventarizācijas vēsture.
            </p>

        </div>

    </div>


    <!-- REPORT FORM -->
    <form
        method="GET"
        action="{{ route('reports.preview') }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]"
    >

        <!-- FORM HEADER -->
        <div class="border-b border-slate-100 px-6 py-5 dark:border-emerald-400/10 sm:px-8">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-300">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <path d="M14 2v6h6"/>
                        <path d="M8 13h8"/>
                        <path d="M8 17h8"/>
                        <path d="M8 9h2"/>
                    </svg>

                </div>

                <div>

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Atskaites parametri
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Norādi, kādu informāciju vēlies iekļaut atskaitē
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6 sm:p-8">

            <!-- REPORT TYPE -->
            <div class="mb-7">

                <label
                    for="report_type"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Atskaites veids
                </label>

                <select
                    id="report_type"
                    name="report_type"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option value="">
                        Izvēlies atskaites veidu
                    </option>

                    <option
                        value="stock"
                        @selected(request('report_type') === 'stock')
                    >
                        Preču atlikumu atskaite
                    </option>

                    <option
                        value="receipts"
                        @selected(request('report_type') === 'receipts')
                    >
                        Preču saņemšanas atskaite
                    </option>

                    <option
                        value="inventory"
                        @selected(request('report_type') === 'inventory')
                    >
                        Inventarizācijas atskaite
                    </option>

                </select>

            </div>


            <!-- DATE PERIOD -->
            <div
                id="date-period"
                class="mb-7 rounded-2xl border border-slate-200 bg-slate-50/60 p-5 dark:border-emerald-400/10 dark:bg-emerald-400/[0.025]"
            >

                <div class="mb-5">

                    <div class="flex items-center gap-2">

                        <svg
                            class="h-4 w-4 text-emerald-600 dark:text-emerald-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                            <path d="M16 3v4"/>
                            <path d="M8 3v4"/>
                            <path d="M3 11h18"/>
                        </svg>

                        <p class="font-bold text-slate-800 dark:text-slate-200">
                            Laika periods
                        </p>

                    </div>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Norādi periodu, par kuru nepieciešams sagatavot atskaiti.
                    </p>

                </div>


                <div class="grid gap-4 md:grid-cols-2">

                    <!-- FROM -->
                    <div>

                        <label
                            for="date_from"
                            class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                        >
                            No
                        </label>

                        <input
                            type="date"
                            id="date_from"
                            name="date_from"
                            value="{{ request('date_from') }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50"
                        >

                    </div>


                    <!-- TO -->
                    <div>

                        <label
                            for="date_to"
                            class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                        >
                            Līdz
                        </label>

                        <input
                            type="date"
                            id="date_to"
                            name="date_to"
                            value="{{ request('date_to') }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50"
                        >

                    </div>

                </div>

            </div>


            <!-- STOCK REPORT INFO -->
            <div
                id="stock-report-info"
                class="mb-7 hidden rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-400/20 dark:bg-emerald-400/[0.08]"
            >

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 text-emerald-600 dark:text-emerald-300">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5"/>
                            <path d="M12 8h.01"/>
                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-200">
                            Laika periods nav nepieciešams
                        </p>

                        <p class="mt-1 text-xs text-emerald-700/80 dark:text-emerald-300/70">
                            Preču atlikumu atskaite izmanto pašreizējos noliktavas datus.
                        </p>

                    </div>

                </div>

            </div>


            <!-- ACTION -->
            <div class="flex justify-end border-t border-slate-100 pt-6 dark:border-emerald-400/10">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-400 px-6 py-3 text-sm font-bold text-[#07110f] shadow-sm transition hover:bg-emerald-300"
                >

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <path d="M14 2v6h6"/>
                        <path d="M12 18v-6"/>
                        <path d="m9 15 3 3 3-3"/>
                    </svg>

                    Ģenerēt atskaiti

                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const reportType =
        document.getElementById('report_type');

    const datePeriod =
        document.getElementById('date-period');

    const stockReportInfo =
        document.getElementById('stock-report-info');


    function updateDateFields() {

        if (reportType.value === 'stock') {

            datePeriod.style.display = 'none';
            stockReportInfo.style.display = 'block';

        } else {

            datePeriod.style.display = 'block';
            stockReportInfo.style.display = 'none';

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