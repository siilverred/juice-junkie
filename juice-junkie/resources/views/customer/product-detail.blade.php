@extends('layouts.app')

@section('title', $product->name)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .rating-stars i {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .rating-stars:hover i {
        color: #d1d5db; /* gray-300 */
    }
    .rating-stars i:hover ~ i {
        color: #d1d5db; /* gray-300 */
    }
    .rating-stars:hover i:hover {
        color: #f59e0b; /* yellow-500 */
    }
    .rating-stars:hover i:hover ~ i {
        color: #f59e0b; /* yellow-500 */
    }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-500">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products') }}" class="hover:text-orange-500">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $product->name }}</span>
        </div>
        
        <!-- Product Details -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2">
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-r from-red-100 to-yellow-100 flex items-center justify-center">
                            <i class="fas fa-glass-whiskey text-orange-300 text-6xl"></i>
                        </div>
                    @endif
                </div>
                
                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            @php
                                $rating = $product->average_rating;
                                $fullStars = floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp
                            
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            
                            @if($halfStar)
                                <i class="fas fa-star-half-alt"></i>
                            @endif
                            
                            @for($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-gray-600 text-sm">({{ $product->ratings->count() }} reviews)</span>
                    </div>
                    
                    <p class="text-2xl font-bold text-orange-500 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <div class="border-t border-b py-4 mb-6">
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form mb-6">
                        @csrf
                        <div class="flex items-center mb-4">
                            <label for="quantity" class="mr-4 font-medium">Quantity:</label>
                            <div class="flex items-center border rounded-md">
                                <button type="button" class="px-3 py-1 text-gray-600 hover:text-orange-500 decrease-qty">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-12 text-center border-0 focus:ring-0">
                                <button type="button" class="px-3 py-1 text-gray-600 hover:text-orange-500 increase-qty">+</button>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                        </button>
                    </form>
                    
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="flex items-center mr-6">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>In Stock</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-tag text-orange-500 mr-2"></i>
                            <span>Category: {{ $product->category->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Description and Reviews Tabs -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
            <div class="border-b">
                <div class="flex" x-data="{ activeTab: 'description' }">
                    <button @click="activeTab = 'description'" :class="{ 'border-b-2 border-orange-500 text-orange-500': activeTab === 'description' }" class="px-6 py-4 font-medium text-gray-700 hover:text-orange-500 focus:outline-none">
                        Description
                    </button>
                    <button @click="activeTab = 'reviews'" :class="{ 'border-b-2 border-orange-500 text-orange-500': activeTab === 'reviews' }" class="px-6 py-4 font-medium text-gray-700 hover:text-orange-500 focus:outline-none">
                        Reviews ({{ $product->ratings->count() }})
                    </button>
                </div>
            </div>
            
            <div class="p-6" x-data="{ activeTab: 'description' }">
                <div x-show="activeTab === 'description'">
                    <h2 class="text-xl font-semibold mb-4">Product Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3">Benefits</h3>
                        <ul class="list-disc pl-5 space-y-2 text-gray-700">
                            <li>Made from fresh, organic ingredients</li>
                            <li>No added sugar or preservatives</li>
                            <li>Rich in vitamins and antioxidants</li>
                            <li>Supports immune system health</li>
                        </ul>
                    </div>
                </div>
                
                <div x-show="activeTab === 'reviews'">
                    <h2 class="text-xl font-semibold mb-4">Customer Reviews</h2>
                    
                    @auth
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="font-medium mb-3">Write a Review</h3>
                            <form action="{{ route('products.rate', $product) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex text-gray-300 text-2xl rating-stars" id="rating-stars">
                                        <i class="fas fa-star" data-rating="1"></i>
                                        <i class="fas fa-star" data-rating="2"></i>
                                        <i class="fas fa-star" data-rating="3"></i>
                                        <i class="fas fa-star" data-rating="4"></i>
                                        <i class="fas fa-star" data-rating="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="5">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                                    <textarea id="review" name="review" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"></textarea>
                                </div>
                                
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-4 rounded-md transition-all duration-300">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg mb-6 text-center">
                            <p class="text-gray-600 mb-2">Please login to write a review</p>
                            <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-medium">Login here</a>
                        </div>
                    @endauth
                    
                    <div class="space-y-6">
                        @forelse($product->ratings as $rating)
                            <div class="border-b pb-6 last:border-b-0">
                                <div class="flex items-center mb-2">
                                    <div class="w-10 h-10 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500 mr-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium">{{ $rating->user->name }}</h4>
                                        <div class="flex text-yellow-400 text-sm">
                                            @php
                                                $ratingValue = $rating->rating;
                                                $fullStars = floor($ratingValue);
                                                $halfStar = $ratingValue - $fullStars >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                            @endphp
                                            
                                            @for($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            
                                            @if($halfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            
                                            @for($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="ml-auto text-sm text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <p class="text-gray-700">{{ $rating->review }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 gradient-text">Related Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}">
                            @if($relatedProduct->image)
                                <img src="{{ asset('images/products/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-red-100 to-yellow-100 flex items-center justify-center">
                                    <i class="fas fa-glass-whiskey text-orange-300 text-3xl"></i>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            <!-- Add star ratings to related products -->
                            <div class="flex text-yellow-400 mb-2">
                                @php
                                    $rating = $relatedProduct->average_rating;
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                
                                @for($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                
                                @if($halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif
                                
                                @for($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                                <span class="text-gray-500 text-xs ml-1">({{ $relatedProduct->ratings->count() }})</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-500 font-bold">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                <form action="{{ route('cart.add', $relatedProduct) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-1.5 px-3 rounded-full text-sm font-medium transition-all duration-300">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons
        const decreaseBtn = document.querySelector('.decrease-qty');
        const increaseBtn = document.querySelector('.increase-qty');
        const quantityInput = document.getElementById('quantity');
        
        decreaseBtn.addEventListener('click', function() {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
        
        // Rating stars
        const ratingStars = document.querySelectorAll('#rating-stars i');
        const ratingInput = document.getElementById('rating-input');
        
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                
                // Update stars
                ratingStars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    });
</script>
@endsection