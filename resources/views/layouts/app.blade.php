<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'StockManager')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 shrink-0 bg-slate-900 text-white">

        <!-- LOGO -->
        <div class="border-b border-slate-700 p-6">

            <h1 class="text-2xl font-bold">
                Stock<span class="text-blue-500">Manager</span>
            </h1>

            <p class="mt-1 text-xs text-slate-400">
                Noliktavas pārvaldības sistēma
            </p>

        </div>


        <!-- NAVIGATION -->
        <nav class="space-y-2 p-4">

            <!-- DASHBOARD -->
            <a
                href="{{ route('dashboard') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Pārskats
            </a>


            <!-- PRODUCTS -->
            <a
                href="{{ route('products.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('products.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Preces
            </a>


            <!-- ADMIN ONLY -->
            @if(auth()->user()->isAdmin())

                <!-- CATEGORIES -->
                <a
                    href="{{ route('categories.index') }}"
                    class="block rounded-lg px-4 py-3 transition
                    {{ request()->routeIs('categories.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    Kategorijas
                </a>


                <!-- WAREHOUSE STRUCTURE -->
                <a
                    href="{{ route('warehouse-locations.index') }}"
                    class="block rounded-lg px-4 py-3 transition
                    {{ request()->routeIs('warehouse-locations.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    Noliktavas struktūra
                </a>

            @endif


            <div class="my-3 border-t border-slate-700"></div>


            <!-- CUSTOMER ORDERS -->
            <a
                href="{{ route('customer-orders.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('customer-orders.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Pasūtījumi
            </a>


            <!-- STOCK RECEIPTS -->
            <a
                href="{{ route('stock-receipts.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('stock-receipts.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Preču saņemšana
            </a>


            <!-- STOCK ISSUES -->
            <a
                href="{{ route('stock-issues.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('stock-issues.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Preču izsniegšana
            </a>


            <!-- INVENTORY -->
            <a
                href="{{ route('inventory-adjustments.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('inventory-adjustments.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Inventarizācija
            </a>


            <!-- PURCHASE PLANNING -->
            <a
                href="{{ route('purchase-planning.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('purchase-planning.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Iepirkumu plānošana
            </a>


            <!-- REPORTS -->
            <a
                href="{{ route('reports.index') }}"
                class="block rounded-lg px-4 py-3 transition
                {{ request()->routeIs('reports.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                Atskaites
            </a>

        </nav>

    </aside>


    <!-- MAIN -->
    <main class="min-w-0 flex-1">

        <!-- TOP BAR -->
        <header class="flex items-center justify-between bg-white px-8 py-5 shadow-sm">

            <h2 class="text-xl font-semibold text-gray-800">
                @yield('page-title', 'StockManager')
            </h2>


            <div class="flex items-center gap-5">

                <!-- USER -->
                <div class="text-right">

                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-sm text-gray-500">

                        @if(auth()->user()->isAdmin())
                            Administrators
                        @else
                            Darbinieks
                        @endif

                    </p>

                </div>


                <!-- LOGOUT -->
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-red-500 px-4 py-2 text-white transition hover:bg-red-600"
                    >
                        Iziet
                    </button>

                </form>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <div class="p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>

</html>