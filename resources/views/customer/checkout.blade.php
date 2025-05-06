@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .payment-method {
        transition: all 0.3s ease;
    }
    .payment-method.selected {
        border-color: #FF5F6D;
        background-color: rgba(255, 95, 109, 0.05);
    }
    .payment-method:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2 gradient-text">Checkout</h1>
        <p class="text-gray-600 mb-8">Complete your order</p>
        
        @if(session()->has('cart') && count(session()->get('cart')) > 0)
            <form action="{{ route('place.order') }}" method="POST" id="checkout-form">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                            <div class="p-6 border-b">
                                <h2 class="text-xl font-semibold">Shipping Information</h2>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Shipping Address</label>
                                        <textarea id="shipping_address" name="shipping_address" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                        <textarea id="notes" name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6 border-b">
                                <h2 class="text-xl font-semibold">Payment Method</h2>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="border rounded-lg p-4 cursor-pointer payment-method" data-method="cash">
                                        <div class="flex items-center">
                                            <input type="radio" id="cash" name="payment_method" value="cash" checked class="h-4 w-4 text-orange-500 focus:ring-orange-500">
                                            <label for="cash" class="ml-2 block text-sm font-medium text-gray-700">Cash on Delivery</label>
                                        </div>
                                        <p class="text-gray-500 text-xs mt-2">Pay when your order arrives</p>
                                    </div>
                                    
                                    <div class="border rounded-lg p-4 cursor-pointer payment-method" data-method="transfer">
                                        <div class="flex items-center">
                                            <input type="radio" id="transfer" name="payment_method" value="transfer" class="h-4 w-4 text-orange-500 focus:ring-orange-500">
                                            <label for="transfer" class="ml-2 block text-sm font-medium text-gray-700">Bank Transfer</label>
                                        </div>
                                        <p class="text-gray-500 text-xs mt-2">Pay via bank transfer</p>
                                    </div>
                                    
                                    <div class="border rounded-lg p-4 cursor-pointer payment-method" data-method="ewallet">
                                        <div class="flex items-center">
                                            <input type="radio" id="ewallet" name="payment_method" value="ewallet" class="h-4 w-4 text-orange-500 focus:ring-orange-500">
                                            <label for="ewallet" class="ml-2 block text-sm font-medium text-gray-700">E-Wallet</label>
                                        </div>
                                        <p class="text-gray-500 text-xs mt-2">Pay with your e-wallet</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-24">
                            <div class="p-6 border-b">
                                <h2 class="text-xl font-semibold">Order Summary</h2>
                            </div>
                            
                            <div class="p-6">
                                <div class="max-h-64 overflow-y-auto mb-4">
                                    @php $totalAmount = 0; @endphp
                                    @foreach(session()->get('cart') as $id => $item)
                                        @php $totalAmount += $item['price'] * $item['quantity']; @endphp
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-red-100 to-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-glass-whiskey text-orange-300"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-sm font-medium">{{ $item['name'] }}</h3>
                                                <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="space-y-4 border-t pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-semibold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-semibold">Free</span>
                                    </div>
                                    
                                    <div class="border-t pt-4 flex justify-between">
                                        <span class="text-lg font-bold">Total</span>
                                        <span class="text-lg font-bold text-orange-500">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-8">
                                    <button type="submit" class="block w-full bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300">
                                        Place Order
                                    </button>
                                    
                                    <a href="{{ route('cart') }}" class="block w-full text-center mt-4 text-orange-500 hover:text-orange-600 font-medium">
                                        Back to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-orange-300 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-semibold mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">You need to add items to your cart before checkout.</p>
                <a href="{{ route('products') }}" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-8 rounded-full inline-flex items-center transition-all duration-300">
                    Browse Products
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentMethods = document.querySelectorAll('.payment-method');
        paymentMethods.forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                paymentMethods.forEach(m => m.classList.remove('selected'));
                
                // Add selected class to clicked method
                this.classList.add('selected');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
        
        // Form validation
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                const phone = document.getElementById('phone').value;
                const address = document.getElementById('shipping_address').value;
                
                if (!phone || !address) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                }
            });
        }
        
        // Initialize selected payment method
        const checkedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (checkedMethod) {
            const methodContainer = checkedMethod.closest('.payment-method');
            methodContainer.classList.add('selected');
        }
    });
</script>
@endsection