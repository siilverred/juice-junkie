@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Detail Pelanggan</h1>
        <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informasi Pelanggan -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-1">
            <div class="flex flex-col items-center mb-4">
                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                    <i class="fas fa-user text-4xl text-indigo-500"></i>
                </div>
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
            
            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Tanggal Bergabung:</span>
                    <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Total Pesanan:</span>
                    <span class="font-medium">{{ $user->orders->count() }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h2 class="text-lg font-semibold mb-4">Riwayat Pesanan</h2>
            
            @if($user->orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->orders as $order)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $statusClass = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ][$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Pelanggan ini belum memiliki pesanan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection