@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Detail Pesanan #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.edit', $order) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Edit Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Informasi Pesanan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Nomor Pesanan</p>
                            <p class="font-semibold">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Tanggal Pesanan</p>
                            <p class="font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <p>
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
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Metode Pembayaran</p>
                            <p class="font-semibold capitalize">{{ $order->payment_method }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Item Pesanan</h2>
                </div>
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->product)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($item->product->image)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <i class="fas fa-box text-indigo-500"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400">Produk tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Informasi Pelanggan</h2>
                </div>
                <div class="p-6">
                    @if($order->user)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Nama</p>
                            <p class="font-semibold">{{ $order->user->name }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <p class="font-semibold">{{ $order->user->email }}</p>
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">User tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Informasi Pengiriman</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Alamat Pengiriman</p>
                        <p class="font-semibold">{{ $order->shipping_address }}</p>
                    </div>
                    @if($order->notes)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Catatan</p>
                            <p class="font-semibold">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection