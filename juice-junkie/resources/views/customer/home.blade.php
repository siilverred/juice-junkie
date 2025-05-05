@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-red-50 to-yellow-50 py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-5xl font-bold mb-4">
                        <span class="gradient-text">JUICE JUNKIE</span>
                    </h1>
                    <p class="text-2xl mb-6">Drink Juice, Stay Fresh</p>
                    <p class="text-gray-600 mb-8 max-w-md">Nikmati kesegaran jus buah dan sayur terbaik untuk gaya hidup sehat Anda. Dibuat dengan bahan-bahan organik pilihan.</p>
                    <a href="{{ route('products') }}" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-8 rounded-full inline-flex items-center pulse-button">
                        Order NOW
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="md:w-1/2">
                <img src="{{ asset('images/products/hero-juice.png') }}" alt="Fresh Juice"
                class="rounded-lg transform transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Products -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold gradient-text">New Products</h2>
                <a href="{{ route('products') }}" class="text-orange-500 hover:text-orange-600 font-medium flex items-center transition-all duration-300">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            
            <!-- Featured Products Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 card-hover">
                    <a href="{{ route('products') }}">
                        <img src="{{ asset('images/products/mango.jpg') }}" alt="Mangga" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('products') }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                Mangga
                            </a>
                        </h3>
                        <!-- Add star ratings -->
                        <div class="flex text-yellow-400 mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-gray-500 text-xs ml-1">(24)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-orange-500 font-bold">Rp 25.000</span>
                            <form action="{{ route('cart.add', 1) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-2 px-4 rounded-full text-sm font-medium transition-all duration-300">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 card-hover">
                    <a href="{{ route('products') }}">
                        <img src="{{ asset('images/products/strawberry.jpg') }}" alt="Strawberry" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('products') }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                Strawberry
                            </a>
                        </h3>
                        <!-- Add star ratings -->
                        <div class="flex text-yellow-400 mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-gray-500 text-xs ml-1">(31)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-orange-500 font-bold">Rp 25.000</span>
                            <form action="{{ route('cart.add', 2) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-2 px-4 rounded-full text-sm font-medium transition-all duration-300">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 card-hover">
                    <a href="{{ route('products') }}">
                        <img src="{{ asset('images/products/dragon-fruit.jpg') }}" alt="Naga Merah" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('products') }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                Naga Merah
                            </a>
                        </h3>
                        <!-- Add star ratings -->
                        <div class="flex text-yellow-400 mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="text-gray-500 text-xs ml-1">(18)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-orange-500 font-bold">Rp 25.000</span>
                            <form action="{{ route('cart.add', 3) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-2 px-4 rounded-full text-sm font-medium transition-all duration-300">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 card-hover">
                    <a href="{{ route('products') }}">
                        <img src="{{ asset('images/products/green-smoothie.jpg') }}" alt="Green Smoothie" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('products') }}" class="text-gray-800 hover:text-orange-500 transition-colors duration-300">
                                Green Smoothie
                            </a>
                        </h3>
                        <!-- Add star ratings -->
                        <div class="flex text-yellow-400 mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span class="text-gray-500 text-xs ml-1">(15)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-orange-500 font-bold">Rp 25.000</span>
                            <form action="{{ route('cart.add', 4) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white py-2 px-4 rounded-full text-sm font-medium transition-all duration-300">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- About Section -->
    <div id="about" class="py-16 bg-gradient-to-r from-red-50 to-yellow-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="{{ asset('images/products/about-juice.jpg') }}" alt="About Juice Junkie" class="rounded-lg shadow-lg transform transition-transform duration-500 hover:rotate-2">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-3xl font-bold mb-6 gradient-text">About Juice Junkie</h2>
                    <p class="text-gray-600 mb-4">Berdiri sejak 2016, Juice Junkie lahir dari komitmen untuk menghadirkan minuman sehat berkualitas tinggi dengan harga terjangkau. Kami percaya kesehatan tidak harus mahal, dan setiap orang berhak mendapatkan nutrisi segar tanpa compromise.</p>
                    <p class="text-gray-600 mb-4">Produk kami dibuat dari bahan-bahan pilihan, 100% tanpa pengawet, dengan proses yang mempertahankan kandungan gizi dan cita rasa alami buah dan sayur.</p>
                    <p class="text-gray-600 mb-6">Tersedia di platform pesan-antar seperti GrabFood, ShopeeFood, dan GoFood, Juice Junkie memudahkan Anda menikmati kesehatan hanya dalam satu sentuhan.</p>
                    <a href="{{ route('products') }}" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-bold py-3 px-8 rounded-full inline-flex items-center transition-all duration-300">
                        Explore Our Menu
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 gradient-text">Clients Testimonials</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Apa kata pelanggan kami tentang Juice Junkie? Berikut adalah beberapa testimonial dari pelanggan setia kami.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md testimonial-card border-t-4 border-red-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold">Anita Putri</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Jus di sini benar-benar segar dan rasanya enak! Saya selalu mampir ke Juice Junkie setelah olahraga. Favorit saya adalah Mangga Strawberry, rasanya pas dan tidak terlalu manis."</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md testimonial-card border-t-4 border-orange-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold">Budi Santoso</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Sebagai pekerja kantoran, Juice Junkie adalah penyelamat saya. Green Smoothie mereka membantu saya tetap sehat dan berenergi sepanjang hari. Pelayanannya juga ramah dan cepat!"</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md testimonial-card border-t-4 border-yellow-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold">Citra Dewi</h3>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Berry Mix adalah jus terenak yang pernah saya coba! Saya suka sekali dengan konsistensi Juice Junkie dalam menjaga kualitas produk mereka. Selalu segar dan nikmat setiap kali pesan."</p>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('testimonials.index') }}" class="text-orange-500 hover:text-orange-600 font-medium inline-flex items-center transition-all duration-300">
                    View All Testimonials
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Featured Product Banner -->
    <div class="py-12 bg-gradient-to-r from-red-50 to-yellow-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="md:w-1/2 p-8">
                    <h3 class="text-2xl font-bold mb-2 text-yellow-500">LEMON JUICE</h3>
                    <p class="text-4xl font-bold mb-4">NEW Product</p>
                    <p class="text-gray-600 mb-6">Nikmati kesegaran lemon dalam setiap tegukan. Kaya vitamin C dan antioksidan untuk meningkatkan daya tahan tubuh Anda.</p>
                    <a href="{{ route('products') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-white font-bold py-3 px-8 rounded-full inline-flex items-center transition-all duration-300">
                        Order NOW
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/products/lemon-juice.jpg') }}" alt="Lemon Juice" class="w-full h-full object-cover transform transition-transform duration-500 hover:scale-105">
                </div>
            </div>
        </div>
    </div>
@endsection