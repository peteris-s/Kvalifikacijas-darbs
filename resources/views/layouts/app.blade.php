<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'StockManager')</title>

    <!--
        Dark mode tiek uzlikts PIRMS lapas renderēšanas,
        lai refresh laikā nebūtu balts flash.
    -->
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

<body class="bg-[#f4f7f6] text-slate-900 antialiased transition-colors duration-200 dark:bg-[#07110f] dark:text-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col bg-[#0b1614] text-white dark:bg-[#050b0a]">

        <!-- BRAND -->
        <div class="px-6 pb-6 pt-7">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20">

                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>

                </div>

                <div>

                    <div class="text-xl font-bold tracking-tight">
                        Stock<span class="text-emerald-400">Manager</span>
                    </div>

                    <p class="mt-0.5 text-[11px] font-medium uppercase tracking-[0.16em] text-slate-500">
                        Warehouse System
                    </p>

                </div>

            </a>

        </div>


        <!-- NAVIGATION -->
        <nav class="flex-1 overflow-y-auto px-4 pb-6">

            <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-600">
                Galvenais
            </p>


            <!-- DASHBOARD -->
            <a
                href="{{ route('dashboard') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>

                <span>Pārskats</span>
            </a>


            <!-- PRODUCTS -->
            <a
                href="{{ route('products.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('products.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="m7.5 4.27 9 5.15"/>
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>

                <span>Preces</span>
            </a>


            @if(auth()->user()->isAdmin())

                <!-- CATEGORIES -->
                <a
                    href="{{ route('categories.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('categories.*')
                        ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                        : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
                >
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 6h18"/>
                        <path d="M3 12h18"/>
                        <path d="M3 18h18"/>
                        <circle cx="6" cy="6" r="1"/>
                        <circle cx="6" cy="12" r="1"/>
                        <circle cx="6" cy="18" r="1"/>
                    </svg>

                    <span>Kategorijas</span>
                </a>


                <!-- WAREHOUSE -->
                <a
                    href="{{ route('warehouse-locations.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('warehouse-locations.*')
                        ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                        : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
                >
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 21V9l9-6 9 6v12"/>
                        <path d="M3 9h18"/>
                        <path d="M8 13h3v3H8z"/>
                        <path d="M13 13h3v3h-3z"/>
                        <path d="M8 18h3v3H8z"/>
                        <path d="M13 18h3v3h-3z"/>
                    </svg>

                    <span>Noliktavas struktūra</span>
                </a>

            @endif


            <!-- OPERATIONS -->
            <p class="mb-2 mt-7 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-600">
                Noliktavas darbības
            </p>


            <!-- ORDERS -->
            <a
                href="{{ route('customer-orders.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('customer-orders.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                    <path d="M3 6h18"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>

                <span>Pasūtījumi</span>
            </a>


            <!-- RECEIPTS -->
            <a
                href="{{ route('stock-receipts.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('stock-receipts.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 3v12"/>
                    <path d="m7 10 5 5 5-5"/>
                    <path d="M5 21h14"/>
                </svg>

                <span>Preču saņemšana</span>
            </a>


            <!-- ISSUE HISTORY -->
            <a
                href="{{ route('stock-issues.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('stock-issues.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M3 12a9 9 0 1 0 3-6.7"/>
                    <path d="M3 4v5h5"/>
                    <path d="M12 7v5l3 2"/>
                </svg>

                <span>Izsniegšanas vēsture</span>
            </a>


            <!-- INVENTORY -->
            <a
                href="{{ route('inventory-adjustments.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('inventory-adjustments.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 11 12 14 22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>

                <span>Inventarizācija</span>
            </a>


            <!-- PURCHASE PLANNING -->
            <a
                href="{{ route('purchase-planning.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('purchase-planning.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 3v18h18"/>
                    <path d="m7 16 4-5 4 3 5-7"/>
                </svg>

                <span>Iepirkumu plānošana</span>
            </a>


            <!-- REPORTS -->
            <a
                href="{{ route('reports.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs('reports.*')
                    ? 'bg-emerald-400 text-[#0b1614] shadow-lg shadow-emerald-950/20'
                    : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }}"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 3v18h18"/>
                    <path d="M7 16v-5"/>
                    <path d="M12 16V8"/>
                    <path d="M17 16V5"/>
                </svg>

                <span>Atskaites</span>
            </a>

        </nav>


        <!-- USER CARD -->
        <div class="border-t border-white/[0.06] p-4">

            <div class="rounded-2xl bg-white/[0.05] p-3">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-400 font-bold text-[#0b1614]">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="truncate text-sm font-semibold text-white">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-slate-500">
                            @if(auth()->user()->isAdmin())
                                Administrators
                            @else
                                Darbinieks
                            @endif
                        </p>

                    </div>


                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            title="Iziet"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-500/10 hover:text-red-400"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <path d="m16 17 5-5-5-5"/>
                                <path d="M21 12H9"/>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </aside>


    <!-- MAIN -->
    <main class="ml-72 min-w-0 flex-1">

        <!-- TOP BAR -->
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl transition-colors duration-200 dark:border-white/[0.07] dark:bg-[#0b1614]/90">

            <div class="flex h-20 items-center justify-between px-8 lg:px-10">

                <!-- PAGE TITLE -->
                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-600 dark:text-emerald-400">
                        StockManager
                    </p>

                    <h2 class="mt-0.5 text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        @yield('page-title', 'StockManager')
                    </h2>

                </div>


                <!-- RIGHT -->
                <div class="flex items-center gap-3">

                    <!-- THEME SWITCH -->
                    <button
                        id="theme-toggle"
                        type="button"
                        title="Mainīt dizaina režīmu"
                        class="relative flex h-10 w-[76px] items-center rounded-full border border-slate-200 bg-slate-100 p-1 shadow-sm transition-colors duration-300 dark:border-white/10 dark:bg-[#15231f]"
                    >
                        <!-- SUN -->
                        <span class="absolute left-2 flex h-5 w-5 items-center justify-center text-amber-500 transition-opacity dark:opacity-40">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
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


                        <!-- MOON -->
                        <span class="absolute right-2 flex h-5 w-5 items-center justify-center text-emerald-400 opacity-40 transition-opacity dark:opacity-100">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                            </svg>

                        </span>


                        <!-- MOVING KNOB -->
                        <span
                            id="theme-toggle-knob"
                            class="relative z-10 h-8 w-8 translate-x-0 rounded-full bg-white shadow-md transition-transform duration-300 dark:translate-x-9 dark:bg-emerald-400"
                        ></span>

                    </button>


                    <!-- SYSTEM STATUS -->
                    <div class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-medium text-slate-600 shadow-sm transition-colors dark:border-white/10 dark:bg-white/[0.05] dark:text-slate-300 sm:flex">

                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                        Sistēma darbojas

                    </div>


                    <!-- ROLE -->
                    <div class="hidden rounded-full bg-slate-100 px-3.5 py-2 text-xs font-semibold text-slate-600 transition-colors dark:bg-white/[0.06] dark:text-slate-300 md:block">

                        @if(auth()->user()->isAdmin())
                            Administrators
                        @else
                            Darbinieks
                        @endif

                    </div>

                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <div class="px-8 py-8 lg:px-10 lg:py-10">

            <div class="mx-auto max-w-[1600px]">
                @yield('content')
            </div>

        </div>

    </main>

</div>


<!-- DARK MODE -->
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