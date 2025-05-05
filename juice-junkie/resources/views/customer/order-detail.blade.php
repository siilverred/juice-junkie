@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('orders.index') }}" class="hover:text-orange-500">My Orders</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $order->order_number }}</span>
        </div>
        
        <h1 class="text-4xl font-bold mb-2 gradient-text">Order Details</h1>
        <p class="text-gray-600 mb-8">Order #{{ $order->order_number }}</p>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Order Summary</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-wrap -mx-4 mb-6">
                            <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Order Date</h3>
                                <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            
                            <div class="w-full md:w-1/2 px-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Order Status</h3>
                                <p>
                                    @if($order->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Processing
                                        </span>
                                    @elseif($order->status == 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t pt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Order Items</h3>
                            
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center">
                                        <div class="w-16 h-16 bg-gradient-to-r from-red-100 to-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <i class="fas fa-glass-whiskey text-orange-300 text-xl"></i>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <h4 class="font-medium">
                                                {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="font-medium">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Order Details</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Shipping Address</h3>
                                <p class="text-gray-700">{{ $order->shipping_address }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Method</h3>
                                <p class="text-gray-700 capitalize">{{ $order->payment_method }}</p>
                            </div>
                            
                            @if($order->notes)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Order Notes</h3>
                                    <p class="text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 pt-6 border-t">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">Free</span>
                            </div>
                            
                            <div class="flex justify-between pt-4 border-t mt-4">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-lg font-bold text-orange-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('orders.index') }}" class="block text-center text-orange-500 hover:text-orange-600 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection