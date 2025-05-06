<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Create default users when the application boots
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
            // Log error but don't crash the application
            \Log::error('Error creating default users in AppServiceProvider', [
                'error' => $e->getMessage()
            ]);
        }
    }
}