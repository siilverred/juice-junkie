@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Laporan Penjualan</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reports.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-pdf mr-2"></i> Unduh PDF
            </a>
            <a href="{{ route('admin.reports.excel') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-excel mr-2"></i> Unduh Excel
            </a>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="md:w-auto flex items-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-sync-alt mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-indigo-500"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500">Total Pesanan</h2>
                    <p class="text-2xl font-semibold">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500">Total Penjualan</h2>
                    <p class="text-2xl font-semibold">Rp {{ number_format($totalSales ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-box text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500">Total Produk Terjual</h2>
                    <p class="text-2xl font-semibold">{{ $totalProductsSold ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-users text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500">Pelanggan Aktif</h2>
                    <p class="text-2xl font-semibold">{{ $activeCustomers ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Tabel -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Grafik Penjualan Bulanan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Penjualan Bulanan</h2>
            <div class="h-64">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
        
        <!-- Grafik Status Pesanan -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Status Pesanan</h2>
            <div class="h-64">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Produk Terlaris</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terjual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topProducts ?? [] as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->category->name ?? 'Tidak ada kategori' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->total_sold }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($product->total_sales, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk grafik (akan diisi dari controller)
            const monthlySalesData = @json($monthlySalesData ?? []);
            const orderStatusData = @json($orderStatusData ?? []);
            
            // Grafik Penjualan Bulanan
            if (document.getElementById('monthlySalesChart')) {
                const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
                new Chart(monthlySalesCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlySalesData.labels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: monthlySalesData.data ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: 'rgba(79, 70, 229, 0.2)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Grafik Status Pesanan
            if (document.getElementById('orderStatusChart')) {
                const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
                new Chart(orderStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: orderStatusData.labels ?? ['Pending', 'Processing', 'Completed', 'Cancelled'],
                        datasets: [{
                            data: orderStatusData.data ?? [0, 0, 0, 0],
                            backgroundColor: [
                                'rgba(251, 191, 36, 0.7)',
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(239, 68, 68, 0.7)'
                            ],
                            borderColor: [
                                'rgba(251, 191, 36, 1)',
                                'rgba(59, 130, 246, 1)',
                                'rgba(16, 185, 129, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }
        });
    </script>
@endsection