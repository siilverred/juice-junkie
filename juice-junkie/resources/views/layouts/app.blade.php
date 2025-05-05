<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(to right, #FF5F6D, #FFC371);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(to right, #FF5F6D, #FFC371);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .testimonial-card {
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: scale(1.03);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(to right, #FF5F6D, #FFC371);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .pulse-button {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 95, 109, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(255, 95, 109, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 95, 109, 0);
            }
        }
        .rotate-hover:hover {
            transform: rotate(5deg);
        }
        .scale-hover:hover {
            transform: scale(1.05);
        }
        .cart-item-added {
            animation: cartAdded 0.7s ease-in-out;
        }
        @keyframes cartAdded {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        .header-gradient {
            background: linear-gradient(to right, #fff0e8, #fff5e8);
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(to right, #FF5F6D, #FFC371);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Fix for register button white shade */
        .register-btn {
            border: none;
            outline: none;
            box-shadow: none;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="header-gradient shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-2">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Juice Junkie" class="h-12 md:h-14 rotate-hover transition-all duration-300">
                </a>
                
                <div class="hidden md:flex space-x-10">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 font-medium nav-link text-lg">Home</a>
                    <a href="{{ route('products') }}" class="text-gray-700 hover:text-orange-500 font-medium nav-link text-lg">Products</a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart') }}" class="text-gray-700 hover:text-orange-500 relative scale-hover transition-all duration-300">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                        @if(session()->has('cart') && count(session()->get('cart')) > 0)
                            <span class="cart-count" id="cart-count">
                                {{ count(session()->get('cart')) }}
                            </span>
                        @endif
                    </a>
                    
                    <div class="md:hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-700 hover:text-orange-500">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute top-16 right-4 bg-white shadow-lg rounded-lg py-2 w-48 z-50">
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">Home</a>
                            <a href="{{ route('products') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">Products</a>
                            
                            @auth
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">My Orders</a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-orange-100">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-100">Register</a>
                            @endauth
                        </div>
                    </div>
                    
                    @auth
                        <div class="relative hidden md:block" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-orange-500">
                                <span class="mr-1">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100">Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100">My Orders</a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium text-lg">Login</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white px-6 py-1.5 rounded-full font-medium transition-all duration-300 register-btn">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mx-auto px-4 py-3">
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mx-auto px-4 py-3">
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center">
                <div class="w-full md:w-auto mb-6 md:mb-0 flex flex-col items-center md:items-start">
                    <img src="{{ asset('images/logo.png') }}" alt="Juice Junkie" class="h-16 mb-2">
                    <p class="text-gray-400 text-sm">Minuman sehat sejak 2016</p>
                </div>
                
                <div class="w-full md:w-auto mb-6 md:mb-0 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-12 items-center md:items-start">
                    <div>
                        <h3 class="text-sm font-bold mb-2 gradient-text">Quick Links</h3>
                        <ul class="flex flex-wrap justify-center md:justify-start space-x-4 text-sm text-gray-400">
                            <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition-colors duration-300">Home</a></li>
                            <li><a href="{{ route('products') }}" class="hover:text-orange-500 transition-colors duration-300">Products</a></li>
                            <li><a href="{{ route('testimonials.index') }}" class="hover:text-orange-500 transition-colors duration-300">Testimonials</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-bold mb-2 gradient-text">Contact</h3>
                        <p class="text-sm text-gray-400">Multatuli AA 37-38, Medan</p>
                        <p class="text-sm text-gray-400">Mon-Sat 09:00-19:00</p>
                    </div>
                </div>
                
                <div class="w-full md:w-auto flex justify-center md:justify-start">
                    <a href="https://www.instagram.com/juicejunkie.mdn" target="_blank" class="text-gray-400 hover:text-orange-500 text-xl transition-colors duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-800 text-center text-gray-400 text-xs">
                <p>&copy; {{ date('Y') }} Juice Junkie. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Animation Notification -->
    <div id="cart-notification" class="fixed top-24 right-4 bg-white rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300 z-50 flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-2 text-xl"></i>
        <span>Item added to cart!</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    
    <script>
        function showCartNotification() {
            const notification = document.getElementById('cart-notification');
            notification.classList.remove('translate-x-full');
            
            // Animate cart icon
            const cartIcon = document.querySelector('.fa-shopping-cart');
            cartIcon.classList.add('cart-item-added');
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    cartIcon.classList.remove('cart-item-added');
                }, 300);
            }, 2000);
        }
        
        // Add event listener to all add to cart buttons
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartForms = document.querySelectorAll('.add-to-cart-form');
            
            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count
                            const cartCount = document.getElementById('cart-count');
                            if (cartCount) {
                                cartCount.textContent = data.cartCount;
                            } else {
                                // Create cart count if it doesn't exist
                                const cartIcon = document.querySelector('.fa-shopping-cart');
                                const countSpan = document.createElement('span');
                                countSpan.id = 'cart-count';
                                countSpan.className = 'cart-count';
                                countSpan.textContent = data.cartCount;
                                cartIcon.parentElement.appendChild(countSpan);
                            }
                            
                            showCartNotification();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>