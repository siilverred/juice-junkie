@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .quantity-input {
        width: 60px;
        text-align: center;
    }
    .quantity-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(to right, #FF5F6D, #FFC371);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .quantity-btn:hover {
        transform: scale(1.1);
    }
    .cart-item {
        transition: all 0.3s ease;
    }
    .cart-item.removing {
        opacity: 0;
        transform: translateX(50px);
    }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2 gradient-text">Your Shopping Cart</h1>
        <p class="text-gray-600 mb-8">Review your items before checkout</p>
        
        @if(session()->has('cart') && count(session()->get('cart')) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold">Cart Items ({{ count(session()->get('cart')) }})</h2>
                        </div>
                        
                        <div class="divide-y">
                            @php $totalAmount = 0; @endphp
                            @foreach(session()->get('cart') as $id => $item)
                                @php $totalAmount += $item['price'] * $item['quantity']; @endphp
                                <div class="p-6 flex flex-col md:flex-row items-center cart-item" id="cart-item-{{ $id }}">
                                    <div class="md:w-1/4 mb-4 md:mb-0">
                                        @if(isset($item['image']))
                                            <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-24 h-24 object-cover rounded-lg mx-auto">
                                        @else
                                            <div class="w-24 h-24 bg-gradient-to-r from-red-100 to-yellow-100 rounded-lg flex items-center justify-center mx-auto">
                                                <i class="fas fa-glass-whiskey text-orange-300 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="md:w-2/4 text-center md:text-left mb-4 md:mb-0">
                                        <h3 class="text-lg font-semibold">{{ $item['name'] }}</h3>
                                        <p class="text-orange-500 font-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="md:w-1/4 flex items-center justify-center md:justify-end space-x-2">
                                        <div class="flex items-center space-x-2">
                                            <button class="quantity-btn decrease-btn" data-id="{{ $id }}">-</button>
                                            <input type="number" min="1" value="{{ $item['quantity'] }}" class="quantity-input border border-gray-300 rounded-md py-1" data-id="{{ $id }}">
                                            <button class="quantity-btn increase-btn" data-id="{{ $id }}">+</button>
                                        </div>
                                        
                                        <button class="text-red-500 hover:text-red-700 ml-4 remove-item-btn" data-id="{{ $id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
                            <div class="space-y-4">
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
                                <a href="{{ route('checkout') }}" class="block w-full bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300">
                                    Proceed to Checkout
                                </a>
                                
                                <a href="{{ route('products') }}" class="block w-full text-center mt-4 text-orange-500 hover:text-orange-600 font-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-orange-300 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-semibold mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
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
        // Increase quantity
        const increaseButtons = document.querySelectorAll('.increase-btn');
        increaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                input.value = parseInt(input.value) + 1;
                updateCart(id, input.value);
            });
        });
        
        // Decrease quantity
        const decreaseButtons = document.querySelectorAll('.decrease-btn');
        decreaseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateCart(id, input.value);
                }
            });
        });
        
        // Input change
        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                if (parseInt(this.value) < 1) {
                    this.value = 1;
                }
                updateCart(id, this.value);
            });
        });
        
        // Remove item
        const removeButtons = document.querySelectorAll('.remove-item-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const cartItem = document.getElementById(`cart-item-${id}`);
                cartItem.classList.add('removing');
                
                setTimeout(() => {
                    removeFromCart(id);
                }, 300);
            });
        });
        
        // Update cart function
        function updateCart(id, quantity) {
            fetch('{{ route("cart.update") }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: id,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to update totals
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Remove from cart function
        function removeFromCart(id) {
            fetch('{{ route("cart.remove") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to update cart
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>
@endsection