<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'JuiceJunkie') }} - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-indigo-700 border-r">
                    <div class="flex flex-col items-center flex-shrink-0 px-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-white">
                            Juice Junkie Admin
                        </a>
                    </div>
                    <div class="flex flex-col flex-grow px-4 mt-5">
                        <nav class="flex-1 space-y-1 bg-indigo-700">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-box mr-3"></i>
                                Produk
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Pesanan
                            </a>
                            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-users mr-3"></i>
                                Pelanggan
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-chart-bar mr-3"></i>
                                Laporan
                            </a>
                        </nav>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-600">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('title')</h1>
                    </div>
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        <div class="py-4">
                            @if(session('success'))
                                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>