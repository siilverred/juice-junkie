@extends('layouts.app')

@section('title', 'Testimonials')

@section('content')
    <div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2 gradient-text">Customer Testimonials</h1>
            <p class="text-gray-600 mb-8">What our customers say about us</p>
            
            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-xl shadow-md testimonial-card border-t-4 border-orange-500">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold">{{ $testimonial->user->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $testimonial->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $testimonial->content }}</p>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <i class="fas fa-comments text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-xl">No testimonials yet. Be the first to share your experience!</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Add Testimonial Form -->
            @auth
                <div class="bg-white p-6 rounded-xl shadow-md mb-12">
                    <h2 class="text-2xl font-semibold mb-4">Share Your Experience</h2>
                    <form action="{{ route('testimonials.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your Testimonial</label>
                            <textarea name="content" id="content" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500" placeholder="Share your experience with Juice Junkie..."></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-6 rounded-lg transition-all duration-300">
                                Submit Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-white p-6 rounded-xl shadow-md mb-12 text-center">
                    <p class="text-gray-600 mb-4">Please login to share your testimonial</p>
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-6 rounded-lg transition-all duration-300 inline-block">
                        Login to Continue
                    </a>
                </div>
            @endauth
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
@endsection