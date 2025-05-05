<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure the role column exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function ($table) {
                $table->string('role')->default('customer')->after('password');
            });
        }

        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@juicejunkie.com'],
            [
                'name' => 'Admin Juice Junkie',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create or update customer user
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin and customer users created successfully!');
        $this->command->info('Admin: admin@juicejunkie.com / password123');
        $this->command->info('Customer: customer@example.com / password123');
    }
}