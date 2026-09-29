<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieslēgties | StockManager</title>

    {{-- THEME BEFORE PAGE RENDER --}}
    <script>
        (function () {
            const savedTheme = localStorage.getItem('stockmanager-theme');

            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f4f7f6] text-slate-900 antialiased transition-colors duration-200 dark:bg-[#07110f] dark:text-slate-100">

    <div class="flex min-h-screen">

        {{-- LEFT SIDE --}}
        <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden
                    border-r border-slate-200 bg-white p-12
                    transition-colors duration-200
                    dark:border-emerald-900/30 dark:bg-[#050b0a]
                    lg:flex">

            {{-- BACKGROUND DECORATION --}}
            <div class="pointer-events-none absolute -left-32 top-1/3 h-96 w-96
                        rounded-full bg-emerald-400/10 blur-3xl
                        dark:bg-emerald-500/5">
            </div>

            <div class="pointer-events-none absolute -right-32 bottom-10 h-80 w-80
                        rounded-full bg-emerald-300/10 blur-3xl
                        dark:bg-emerald-400/5">
            </div>


            {{-- LOGO --}}
            <div class="relative z-10">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-emerald-400 text-[#0b1614]
                                shadow-lg shadow-emerald-950/10">

                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>

                        </svg>

                    </div>

                    <div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                            Stock<span class="text-emerald-500 dark:text-emerald-400">Manager</span>
                        </h1>

                        <p class="mt-0.5 text-[11px] font-medium uppercase tracking-[0.16em]
                                  text-slate-400 dark:text-slate-500">
                            Warehouse System
                        </p>

                    </div>

                </div>

            </div>


            {{-- INFORMATION --}}
            <div class="relative z-10 max-w-xl">

                <div class="mb-6 inline-flex items-center gap-2 rounded-full
                            border border-emerald-200 bg-emerald-50
                            px-4 py-2 text-xs font-semibold uppercase
                            tracking-[0.18em] text-emerald-700
                            dark:border-emerald-800/50 dark:bg-emerald-950/40
                            dark:text-emerald-400">

                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                    Noliktavas pārvaldība

                </div>


                <h2 class="max-w-lg text-4xl font-bold leading-tight
                           text-slate-900 dark:text-white xl:text-5xl">

                    Pārvaldi noliktavu
                    <span class="text-emerald-500 dark:text-emerald-400">
                        vienuviet.
                    </span>

                </h2>


                <p class="mt-5 max-w-lg text-lg leading-relaxed
                          text-slate-500 dark:text-slate-400">

                    Pārvaldi preces, noliktavas atlikumus, preču saņemšanu,
                    inventarizāciju, pasūtījumus un atskaites vienā sistēmā.

                </p>


                {{-- FEATURE CARDS --}}
                <div class="mt-10 grid grid-cols-2 gap-4">

                    {{-- PRODUCTS --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-[#f8faf9] p-5 shadow-sm transition
                                hover:border-emerald-300
                                dark:border-white/[0.07]
                                dark:bg-[#0b1614]
                                dark:hover:border-emerald-800">

                        <div class="mb-3 flex h-9 w-9 items-center justify-center
                                    rounded-lg bg-emerald-100 text-emerald-600
                                    dark:bg-emerald-950 dark:text-emerald-400">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                                <path d="m3.3 7 8.7 5 8.7-5"/>
                                <path d="M12 22V12"/>

                            </svg>

                        </div>

                        <p class="font-semibold text-slate-900 dark:text-white">
                            Preču uzskaite
                        </p>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Noliktavas atlikumu pārvaldība
                        </p>

                    </div>


                    {{-- INVENTORY --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-[#f8faf9] p-5 shadow-sm transition
                                hover:border-emerald-300
                                dark:border-white/[0.07]
                                dark:bg-[#0b1614]
                                dark:hover:border-emerald-800">

                        <div class="mb-3 flex h-9 w-9 items-center justify-center
                                    rounded-lg bg-emerald-100 text-emerald-600
                                    dark:bg-emerald-950 dark:text-emerald-400">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M9 11 12 14 22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>

                            </svg>

                        </div>

                        <p class="font-semibold text-slate-900 dark:text-white">
                            Inventarizācija
                        </p>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Atlikumu pārbaude un korekcijas
                        </p>

                    </div>


                    {{-- PURCHASE PLANNING --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-[#f8faf9] p-5 shadow-sm transition
                                hover:border-emerald-300
                                dark:border-white/[0.07]
                                dark:bg-[#0b1614]
                                dark:hover:border-emerald-800">

                        <div class="mb-3 flex h-9 w-9 items-center justify-center
                                    rounded-lg bg-emerald-100 text-emerald-600
                                    dark:bg-emerald-950 dark:text-emerald-400">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M3 3v18h18"/>
                                <path d="m7 16 4-5 4 3 5-7"/>

                            </svg>

                        </div>

                        <p class="font-semibold text-slate-900 dark:text-white">
                            Iepirkumu plānošana
                        </p>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Automātiska zemo atlikumu kontrole
                        </p>

                    </div>


                    {{-- REPORTS --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-[#f8faf9] p-5 shadow-sm transition
                                hover:border-emerald-300
                                dark:border-white/[0.07]
                                dark:bg-[#0b1614]
                                dark:hover:border-emerald-800">

                        <div class="mb-3 flex h-9 w-9 items-center justify-center
                                    rounded-lg bg-emerald-100 text-emerald-600
                                    dark:bg-emerald-950 dark:text-emerald-400">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M3 3v18h18"/>
                                <path d="M7 16v-5"/>
                                <path d="M12 16V8"/>
                                <path d="M17 16V5"/>

                            </svg>

                        </div>

                        <p class="font-semibold text-slate-900 dark:text-white">
                            Atskaites
                        </p>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            PDF un Excel eksports
                        </p>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="relative z-10 flex items-center gap-2 text-sm
                        text-slate-400 dark:text-slate-500">

                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                StockManager — noliktavas pārvaldības sistēma

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="relative flex w-full items-center justify-center
                    bg-[#f4f7f6] p-6
                    transition-colors duration-200
                    dark:bg-[#07110f]
                    lg:w-1/2">


            {{-- THEME SWITCH --}}
            <div class="absolute right-6 top-6 sm:right-8 sm:top-8">

                <button
                    id="theme-toggle"
                    type="button"
                    title="Mainīt dizaina režīmu"
                    class="relative flex h-10 w-[76px] items-center
                           rounded-full border border-slate-200
                           bg-slate-100 p-1 shadow-sm
                           transition-colors duration-300
                           dark:border-white/10 dark:bg-[#15231f]">

                    {{-- SUN --}}
                    <span class="absolute left-2 flex h-5 w-5 items-center
                                 justify-center text-amber-500
                                 transition-opacity dark:opacity-40">

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <circle cx="12" cy="12" r="4"/>
                            <path d="M12 2v2"/>
                            <path d="M12 20v2"/>
                            <path d="m4.93 4.93 1.41 1.41"/>
                            <path d="m17.66 17.66 1.41 1.41"/>
                            <path d="M2 12h2"/>
                            <path d="M20 12h2"/>
                            <path d="m6.34 17.66-1.41 1.41"/>
                            <path d="m19.07 4.93-1.41 1.41"/>

                        </svg>

                    </span>


                    {{-- MOON --}}
                    <span class="absolute right-2 flex h-5 w-5 items-center
                                 justify-center text-emerald-400 opacity-40
                                 transition-opacity dark:opacity-100">

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>

                        </svg>

                    </span>


                    {{-- MOVING KNOB --}}
                    <span
                        id="theme-toggle-knob"
                        class="relative z-10 h-8 w-8 translate-x-0
                               rounded-full bg-white shadow-md
                               transition-transform duration-300
                               dark:translate-x-9 dark:bg-emerald-400">
                    </span>

                </button>

            </div>


            <div class="w-full max-w-md">

                {{-- MOBILE LOGO --}}
                <div class="mb-10 lg:hidden">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center
                                    rounded-xl bg-emerald-400 text-[#0b1614]">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                                <path d="m3.3 7 8.7 5 8.7-5"/>
                                <path d="M12 22V12"/>

                            </svg>

                        </div>

                        <div>

                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                                Stock<span class="text-emerald-500 dark:text-emerald-400">Manager</span>
                            </h1>

                            <p class="text-xs uppercase tracking-[0.18em]
                                      text-slate-400 dark:text-slate-500">
                                Warehouse System
                            </p>

                        </div>

                    </div>

                </div>


                {{-- LOGIN CARD --}}
                <div class="rounded-2xl border border-slate-200
                            bg-white p-8 shadow-xl shadow-slate-200/40
                            transition-colors duration-200
                            dark:border-white/[0.07]
                            dark:bg-[#0b1614]
                            dark:shadow-black/20
                            sm:p-10">

                    {{-- HEADER --}}
                    <div class="mb-8">

                        <div class="mb-5 flex h-12 w-12 items-center justify-center
                                    rounded-xl bg-emerald-100 text-emerald-600
                                    dark:bg-emerald-950 dark:text-emerald-400">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>

                            </svg>

                        </div>

                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                            Pieslēgties
                        </h2>

                        <p class="mt-2 text-slate-500 dark:text-slate-400">
                            Ievadi savus piekļuves datus, lai turpinātu.
                        </p>

                    </div>


                    {{-- ERRORS --}}
                    @if ($errors->any())

                        <div class="mb-6 rounded-xl border border-red-200
                                    bg-red-50 px-4 py-3 text-sm text-red-700
                                    dark:border-red-900/60 dark:bg-red-950/40
                                    dark:text-red-300">

                            <p class="font-semibold">
                                Neizdevās pieslēgties
                            </p>

                            <p class="mt-1">
                                {{ $errors->first() }}
                            </p>

                        </div>

                    @endif


                    {{-- LOGIN FORM --}}
                    <form
                        method="POST"
                        action="{{ route('login.submit') }}"
                        class="space-y-5">

                        @csrf


                        {{-- EMAIL --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-medium
                                       text-slate-700 dark:text-slate-300">

                                E-pasts

                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="vards@epasts.lv"
                                autocomplete="email"
                                required
                                autofocus
                                class="w-full rounded-xl border border-slate-300
                                       bg-white px-4 py-3 text-slate-900
                                       placeholder:text-slate-400 outline-none
                                       transition
                                       hover:border-slate-400
                                       focus:border-emerald-500
                                       focus:ring-2 focus:ring-emerald-500/15
                                       dark:border-white/10
                                       dark:bg-[#07110f]
                                       dark:text-white
                                       dark:placeholder:text-slate-600
                                       dark:hover:border-emerald-900">

                        </div>


                        {{-- PASSWORD --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-medium
                                       text-slate-700 dark:text-slate-300">

                                Parole

                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Ievadi paroli"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-xl border border-slate-300
                                       bg-white px-4 py-3 text-slate-900
                                       placeholder:text-slate-400 outline-none
                                       transition
                                       hover:border-slate-400
                                       focus:border-emerald-500
                                       focus:ring-2 focus:ring-emerald-500/15
                                       dark:border-white/10
                                       dark:bg-[#07110f]
                                       dark:text-white
                                       dark:placeholder:text-slate-600
                                       dark:hover:border-emerald-900">

                        </div>


                        {{-- SUBMIT --}}
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-emerald-400
                                   px-5 py-3 font-bold text-[#0b1614]
                                   shadow-lg shadow-emerald-950/10
                                   transition
                                   hover:bg-emerald-300
                                   focus:outline-none
                                   focus:ring-4 focus:ring-emerald-500/20">

                            Pieslēgties

                        </button>

                    </form>


                    {{-- INFO --}}
                    <div class="mt-8 border-t border-slate-100 pt-6
                                dark:border-white/[0.06]">

                        <div class="flex items-center justify-center gap-2
                                    text-sm text-slate-400 dark:text-slate-500">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>

                            </svg>

                            <span>
                                Piekļuve paredzēta autorizētiem sistēmas lietotājiem.
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- THEME SWITCH --}}
    <script>
        const themeToggle = document.getElementById('theme-toggle');

        themeToggle.addEventListener('click', function () {
            const html = document.documentElement;

            html.classList.toggle('dark');

            if (html.classList.contains('dark')) {
                localStorage.setItem(
                    'stockmanager-theme',
                    'dark'
                );
            } else {
                localStorage.setItem(
                    'stockmanager-theme',
                    'light'
                );
            }
        });
    </script>

</body>

</html>