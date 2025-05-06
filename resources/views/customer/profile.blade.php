@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-gradient-to-r from-red-50 to-yellow-50 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2 gradient-text">My Profile</h1>
        <p class="text-gray-600 mb-8">Manage your account information</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-r from-red-100 to-yellow-100 rounded-full flex items-center justify-center text-orange-500 text-2xl">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                                <p class="text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <nav class="space-y-2">
                            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-gray-700 bg-orange-50 rounded-lg">
                                <i class="fas fa-user-circle mr-3 text-orange-500"></i>
                                <span>Profile Information</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-orange-50 rounded-lg">
                                <i class="fas fa-shopping-bag mr-3 text-orange-500"></i>
                                <span>My Orders</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Profile Information</h2>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">{{ old('address', $customer->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-6 rounded-lg transition-all duration-300">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Change Password</h2>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-red-600 hover:to-yellow-600 text-white font-medium py-2 px-6 rounded-lg transition-all duration-300">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection