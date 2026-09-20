<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pieslēgties | StockManager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        <!-- LEFT SIDE -->
        <div class="hidden w-1/2 flex-col justify-between bg-slate-900 p-12 lg:flex">

            <!-- LOGO -->
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Stock<span class="text-blue-500">Manager</span>
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Noliktavas pārvaldības sistēma
                </p>
            </div>


            <!-- INFORMATION -->
            <div class="max-w-lg">

                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-3xl font-bold text-white">
                    S
                </div>

                <h2 class="text-4xl font-bold leading-tight text-white">
                    Pārvaldi noliktavu
                    vienuviet.
                </h2>

                <p class="mt-5 text-lg leading-relaxed text-slate-400">
                    Pārvaldi preces, noliktavas atlikumus, preču saņemšanu,
                    inventarizāciju un atskaites vienā sistēmā.
                </p>


                <div class="mt-10 grid grid-cols-2 gap-4">

                    <div class="rounded-xl border border-slate-700 bg-slate-800 p-4">
                        <p class="font-semibold text-white">
                            Preču uzskaite
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            Noliktavas atlikumu pārvaldība
                        </p>
                    </div>


                    <div class="rounded-xl border border-slate-700 bg-slate-800 p-4">
                        <p class="font-semibold text-white">
                            Inventarizācija
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            Atlikumu pārbaude un korekcijas
                        </p>
                    </div>


                    <div class="rounded-xl border border-slate-700 bg-slate-800 p-4">
                        <p class="font-semibold text-white">
                            Iepirkumu plānošana
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            Automātiska zemo atlikumu kontrole
                        </p>
                    </div>


                    <div class="rounded-xl border border-slate-700 bg-slate-800 p-4">
                        <p class="font-semibold text-white">
                            Atskaites
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            PDF un Excel eksports
                        </p>
                    </div>

                </div>

            </div>


            <!-- FOOTER -->
            <p class="text-sm text-slate-500">
                StockManager — noliktavas pārvaldības sistēma
            </p>

        </div>


        <!-- RIGHT SIDE -->
        <div class="flex w-full items-center justify-center p-6 lg:w-1/2">

            <div class="w-full max-w-md">

                <!-- MOBILE LOGO -->
                <div class="mb-10 lg:hidden">

                    <h1 class="text-3xl font-bold text-slate-900">
                        Stock<span class="text-blue-600">Manager</span>
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Noliktavas pārvaldības sistēma
                    </p>

                </div>


                <!-- LOGIN CARD -->
                <div class="rounded-2xl bg-white p-8 shadow-sm sm:p-10">

                    <div class="mb-8">

                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl font-bold text-blue-600">
                            S
                        </div>

                        <h2 class="text-3xl font-bold text-gray-900">
                            Pieslēgties
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Ievadi savus piekļuves datus, lai turpinātu.
                        </p>

                    </div>


                    <!-- ERRORS -->
                    @if ($errors->any())

                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                            <p class="font-semibold">
                                Neizdevās pieslēgties
                            </p>

                            <p class="mt-1">
                                {{ $errors->first() }}
                            </p>

                        </div>

                    @endif


                    <!-- LOGIN FORM -->
                    <form
                        method="POST"
                        action="{{ route('login.submit') }}"
                        class="space-y-5">

                        @csrf


                        <!-- EMAIL -->
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-medium text-gray-700">

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
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        </div>


                        <!-- PASSWORD -->
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-medium text-gray-700">

                                Parole
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Ievadi paroli"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        </div>


                        <!-- SUBMIT -->
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">

                            Pieslēgties
                        </button>

                    </form>


                    <!-- INFO -->
                    <div class="mt-8 border-t border-gray-100 pt-6">

                        <p class="text-center text-sm text-gray-400">
                            Piekļuve paredzēta autorizētiem sistēmas lietotājiem.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>