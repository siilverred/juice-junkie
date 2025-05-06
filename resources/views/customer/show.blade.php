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
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Informasi Pelanggan</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-500 text-4xl"></i>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Nama</p>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Tanggal Bergabung</p>
                        <p class="font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    
                    @if($user->customer)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Nomor Telepon</p>
                            <p class="font-semibold">{{ $user->customer->phone ?? 'Tidak ada' }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Alamat</p>
                            <p class="font-semibold">{{ $user->customer->address ?? 'Tidak ada' }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Statistik Pelanggan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-indigo-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Total Pesanan</p>
                            <p class="text-2xl font-bold text-indigo-600">{{ $user->orders->count() }}</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Total Belanja</p>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($user->orders->sum('total_amount'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Riwayat Pesanan -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Riwayat Pesanan</h2>
                </div>
                <div class="p-6">
                    @if($user->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->orders->sortByDesc('created_at') as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900">{{ $order->order_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($order->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif($order->status == 'processing')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Diproses
                                                    </span>
                                                @elseif($order->status == 'completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Dibatalkan
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
                        <div class="text-center py-4">
                            <p class="text-gray-500">Pelanggan ini belum memiliki pesanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection