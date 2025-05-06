<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FixUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing users to avoid duplicates or conflicts
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create admin user
        User::create([
            'name' => 'Admin Juice Junkie',
            'email' => 'admin@juicejunkie.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create customer user
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
        
        $this->command->info('Admin and customer users created successfully!');
        $this->command->info('Admin: admin@juicejunkie.com / password123');
        $this->command->info('Customer: customer@example.com / password123');
    }
}