<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all products
        $products = Product::all();
        
        // Get or create users for ratings
        // Remove the 'role' filter since it might not exist in the users table
        $users = User::take(5)->get();
        
        if ($users->isEmpty()) {
            // If no users exist, create a few
            for ($i = 1; $i <= 5; $i++) {
                $users[] = User::create([
                    'name' => 'Customer ' . $i,
                    'email' => 'customer' . $i . '@example.com',
                    'password' => bcrypt('password123'),
                    'email_verified_at' => now(),
                ]);
            }
        }
        
        // Add ratings to each product
        foreach ($products as $product) {
            $this->addRatingsToProduct($product, $users);
        }
    }
    
    /**
     * Add ratings to a product
     *
     * @param Product $product
     * @param \Illuminate\Support\Collection $users
     * @return void
     */
    private function addRatingsToProduct(Product $product, $users)
    {
        // Number of ratings to add (random between 3 and 8)
        $numRatings = rand(3, 8);
        
        // Delete any existing ratings for this product
        Rating::where('product_id', $product->id)->delete();
        
        // Add new ratings
        for ($i = 0; $i < $numRatings; $i++) {
            $user = $users->random();
            
            // Check if this user already rated this product
            $existingRating = Rating::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
                
            if (!$existingRating) {
                // Generate decimal ratings between 3.0 and 5.0
                $rating = rand(30, 50) / 10;
                
                Rating::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => $rating, // Decimal ratings
                    'review' => $this->getRandomReview(),
                ]);
            }
        }
    }
    
    /**
     * Get a random review text
     *
     * @return string
     */
    private function getRandomReview()
    {
        $reviews = [
            'Rasanya enak dan segar!',
            'Jus favorit saya, selalu pesan ini.',
            'Kualitasnya bagus, tidak terlalu manis.',
            'Sangat menyegarkan, terutama saat cuaca panas.',
            'Kombinasi rasa yang pas, suka sekali!',
            'Porsinya cukup banyak, worth it dengan harganya.',
            'Bahan-bahannya segar, terasa sekali.',
            'Cocok untuk yang sedang diet, tidak pakai gula tambahan.',
            'Pelayanannya cepat dan minumannya enak.',
            'Akan pesan lagi, sangat memuaskan!',
        ];
        
        return $reviews[array_rand($reviews)];
    }
}