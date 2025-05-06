<?php

use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TestimonialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Create default users on application start
Route::get('/', function () {
    // Create default users if they don't exist
    try {
        if (Schema::hasTable('users')) {
            // Ensure the role column exists
            if (!Schema::hasColumn('users', 'role')) {
                Schema::table('users', function ($table) {
                    $table->string('role')->default('customer')->after('password');
                });
            }
            
            // Create admin user if it doesn't exist
            User::updateOrCreate(
                ['email' => 'admin@juicejunkie.com'],
                [
                    'name' => 'Admin Juice Junkie',
                    'password' => Hash::make('password123'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );
            
            // Create customer user if it doesn't exist
            User::updateOrCreate(
                ['email' => 'customer@example.com'],
                [
                    'name' => 'Customer Demo',
                    'password' => Hash::make('password123'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]
            );
        }
    } catch (\Exception $e) {
        Log::error('Error creating default users in home route', [
            'error' => $e->getMessage()
        ]);
    }
    
    // Return the home view
    return app(HomeController::class)->index();
})->name('home');

Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('products.show');

// Make sure auth routes are properly included
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::middleware(['auth'])->group(function () {
    // Cart & Checkout
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    
    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    
    // Ratings
    Route::post('/products/{product}/rate', [TestimonialController::class, 'rateProduct'])->name('products.rate');
});

// Create default users route
Route::get('/create-default-users', function() {
    try {
        // Check if the users table exists
        if (!Schema::hasTable('users')) {
            return "Users table doesn't exist. Please run migrations first.";
        }
        
        // Check if the role column exists
        if (!Schema::hasColumn('users', 'role')) {
            // Add role column if it doesn't exist
            Schema::table('users', function ($table) {
                $table->string('role')->default('customer')->after('password');
            });
        }
        
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@juicejunkie.com'],
            [
                'name' => 'Admin Juice Junkie',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        // Create customer user
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );
        
        // Get all users to verify
        $users = User::all();
        
        return "Default users created successfully!<br><br>Users in database:<br><pre>" . 
            print_r($users->toArray(), true) . "</pre><br><br>" .
            "<a href='/login'>Go to login page</a>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage() . "<br><br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('create.default.users');

// Debug route to check user credentials
Route::get('/debug-users', function() {
    try {
        $users = User::all();
        echo "<h1>Users in Database</h1>";
        echo "<pre>";
        foreach ($users as $user) {
            echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: " . ($user->role ?? 'N/A') . "<br>";
        }
        echo "</pre>";
        
        echo "<h2>Database Configuration</h2>";
        echo "<pre>";
        echo "Connection: " . config('database.default') . "<br>";
        echo "Database: " . config('database.connections.' . config('database.default') . '.database') . "<br>";
        echo "</pre>";
        
        echo "<h2>Tables</h2>";
        echo "<pre>";
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo $tableName . "<br>";
        }
        echo "</pre>";
        
        echo "<h2>Create Default Users</h2>";
        echo "<a href='/create-default-users' class='px-4 py-2 bg-blue-500 text-white rounded'>Create Default Users</a>";
        
        return;
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage() . "<br><br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('debug.users');

// Test login route
Route::get('/test-login', function() {
    try {
        // Create default users if they don't exist
        if (Schema::hasTable('users')) {
            // Ensure the role column exists
            if (!Schema::hasColumn('users', 'role')) {
                Schema::table('users', function ($table) {
                    $table->string('role')->default('customer')->after('password');
                });
            }
            
            // Create admin user if it doesn't exist
            User::updateOrCreate(
                ['email' => 'admin@juicejunkie.com'],
                [
                    'name' => 'Admin Juice Junkie',
                    'password' => Hash::make('password123'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );
            
            // Create customer user if it doesn't exist
            User::updateOrCreate(
                ['email' => 'customer@example.com'],
                [
                    'name' => 'Customer Demo',
                    'password' => Hash::make('password123'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]
            );
        }
        
        $credentials = [
            'email' => 'admin@juicejunkie.com',
            'password' => 'password123'
        ];
        
        if (Auth::attempt($credentials)) {
            return "Login successful! You are logged in as: " . Auth::user()->name . 
                "<br><br><a href='/admin/dashboard'>Go to Admin Dashboard</a>";
        } else {
            return "Login failed. Please check the credentials.";
        }
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage() . "<br><br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('test.login');