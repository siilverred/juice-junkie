@extends('layouts.app')

@section('title', 'Products')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2 gradient-text">Our Products</h1>
            <p class="text-gray-600 mb-8">Discover our fresh and healthy juice selection</p>
            
            <!-- Search and Filter -->
            <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                <form action="{{ route('products') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div class="md:w-1/4">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:w-1/6 flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Category Tabs -->
            <div class="mb-8 overflow-x-auto">
                <div class="flex space-x-4 pb-2">
                    <a href="{{ route('products') }}" class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-gradient-to-r from-red-500 to-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium whitespace-nowrap transition-all duration-300">
                        All Products
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products', ['category' => $category->id]) }}" class="px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-gradient-to-r from-red-500 to-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium whitespace-nowrap transition-all duration-300">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 card-hover">
                        <a href="{{ route('products.show', $product->slug) }}">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-56 object-contain">
                            @else
                                <div class="w-full h-56 bg-gradient-to-r from-red-100 to-yellow-100 flex items-center justify-center">
                                    <i class="fas fa-glass-whiskey text-orange-300 text-4xl"></i>
                                </div>
                            @endif
                        </a>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <!-- Add star ratings -->
                            <div class="flex text-yellow-400 mb-2">
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
                                
                                <span class="text-gray-500 text-xs ml-1">({{ $product->ratings->count() }})</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-500 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-2 px-4 rounded-full text-sm font-medium transition-all duration-300">
                                        <i class="fas fa-cart-plus mr-1"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <i class="fas fa-search text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-xl">No products found. Try a different search.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection