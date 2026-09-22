@extends('layouts.app')

@section('title', 'Rediģēt noliktavas vietu | StockManager')
@section('page-title', 'Noliktavas struktūra')

@section('content')

<div class="mx-auto max-w-3xl">

    <!-- BACK -->
    <a
        href="{{ route('warehouse-locations.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-300"
    >
        <svg
            class="h-4 w-4"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <path d="m15 18-6-6 6-6"/>
        </svg>

        Atpakaļ uz noliktavas struktūru
    </a>


    <!-- HEADER -->
    <div class="mb-8 mt-5">

        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 dark:border-emerald-400/20 dark:bg-emerald-400/10">

            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

            <span class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                Noliktavas vietas rediģēšana
            </span>

        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
            Rediģēt noliktavas vietu
        </h1>

        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Maini zonas vai plaukta informāciju un atrašanās vietu noliktavas struktūrā.
        </p>

    </div>


    <!-- VALIDATION ERRORS -->
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


    <!-- FORM -->
    <form
        method="POST"
        action="{{ route('warehouse-locations.update', $warehouseLocation) }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-emerald-400/15 dark:bg-[#0d1b18]"
    >

        @csrf
        @method('PUT')


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
                        <path d="M3 21h18"/>
                        <path d="M5 21V7l7-4 7 4v14"/>
                        <path d="M9 21v-5h6v5"/>
                    </svg>

                </div>

                <div>

                    <h2 class="font-bold text-slate-900 dark:text-white">
                        Vietas informācija
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Rediģē vietas tipu, nosaukumu un atrašanās struktūru
                    </p>

                </div>

            </div>

        </div>


        <!-- FORM BODY -->
        <div class="p-6 sm:p-8">

            <!-- TYPE -->
            <div class="mb-7">

                <label
                    for="type"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Tips
                </label>

                <select
                    id="type"
                    name="type"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

                    <option
                        value="zone"
                        @selected(old('type', $warehouseLocation->type) === 'zone')
                    >
                        Zona
                    </option>

                    <option
                        value="shelf"
                        @selected(old('type', $warehouseLocation->type) === 'shelf')
                    >
                        Plaukts
                    </option>

                </select>


                <!-- TYPE INFO -->
                <div class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-400/15 dark:bg-emerald-400/[0.06]">

                    <div class="flex items-start gap-3">

                        <svg
                            class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-300"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        <div>

                            <p
                                id="type-info-title"
                                class="text-sm font-bold text-emerald-800 dark:text-emerald-200"
                            >
                                Noliktavas vieta
                            </p>

                            <p
                                id="type-info-text"
                                class="mt-1 text-xs leading-5 text-emerald-700/80 dark:text-emerald-300/70"
                            >
                                Izvēlies, vai šī vieta ir noliktavas zona vai plaukts.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- NAME -->
            <div class="mb-7">

                <label
                    for="name"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Nosaukums
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $warehouseLocation->name) }}"
                    required
                    placeholder="Piemēram, A zona vai Plaukts A1"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

            </div>


            <!-- PARENT ZONE -->
            <div
                id="parent-container"
                class="mb-7"
            >

                <label
                    for="parent_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Zona
                </label>

                <select
                    id="parent_id"
                    name="parent_id"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >

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
                            )
                        >
                            {{ $parent->name }}
                        </option>

                    @endforeach

                </select>

                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                    Izvēlies zonu, kurā atradīsies šis plaukts.
                </p>

            </div>


            <!-- DESCRIPTION -->
            <div>

                <label
                    for="description"
                    class="mb-2 block text-xs font-bold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400"
                >
                    Apraksts
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Papildu informācija par atrašanās vietu..."
                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-400/10 dark:border-emerald-400/10 dark:bg-[#091512] dark:text-slate-100 dark:placeholder:text-slate-600 dark:focus:border-emerald-400/50 dark:focus:bg-[#0b1916]"
                >{{ old('description', $warehouseLocation->description) }}</textarea>

                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                    Apraksts nav obligāts.
                </p>

            </div>


            <!-- ACTIONS -->
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t border-slate-100 pt-6 dark:border-emerald-400/10 sm:flex-row">

                <a
                    href="{{ route('warehouse-locations.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-emerald-400/15 dark:text-slate-300 dark:hover:bg-emerald-400/10 dark:hover:text-emerald-300"
                >
                    Atcelt
                </a>

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
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>

                    Saglabāt izmaiņas

                </button>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const type =
        document.getElementById('type');

    const parentContainer =
        document.getElementById('parent-container');

    const parentSelect =
        document.getElementById('parent_id');

    const typeInfoTitle =
        document.getElementById('type-info-title');

    const typeInfoText =
        document.getElementById('type-info-text');


    function updateForm() {

        if (type.value === 'shelf') {

            parentContainer.style.display = 'block';
            parentSelect.required = true;

            typeInfoTitle.textContent =
                'Noliktavas plaukts';

            typeInfoText.textContent =
                'Plaukts atrodas konkrētā noliktavas zonā, tāpēc tam jābūt piesaistītam zonai.';

        } else {

            parentContainer.style.display = 'none';
            parentSelect.required = false;
            parentSelect.value = '';

            typeInfoTitle.textContent =
                'Noliktavas zona';

            typeInfoText.textContent =
                'Zona ir galvenais noliktavas struktūras līmenis, kurā var atrasties vairāki plaukti.';

        }

    }


    type.addEventListener(
        'change',
        updateForm
    );


    updateForm();

});
</script>

@endsection