<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan kategori sudah ada
        $fruitCategory = Category::firstOrCreate([
            'name' => 'Fruit Juices',
            'slug' => 'fruit-juices',
            'description' => 'Jus buah segar dengan berbagai pilihan rasa'
        ]);

        $vegetableCategory = Category::firstOrCreate([
            'name' => 'Vegetable Juices',
            'slug' => 'vegetable-juices',
            'description' => 'Jus sayuran segar kaya nutrisi'
        ]);

        $mixCategory = Category::firstOrCreate([
            'name' => 'Mix Juices',
            'slug' => 'mix-juices',
            'description' => 'Kombinasi jus buah dan sayur'
        ]);

        $smoothieCategory = Category::firstOrCreate([
            'name' => 'Smoothies',
            'slug' => 'smoothies',
            'description' => 'Smoothie kental dengan berbagai pilihan rasa'
        ]);

        // Daftar produk Juice Junkie
        $products = [
            // Fruit Juices
            [
                'name' => 'Mangga',
                'description' => 'Jus mangga segar tanpa tambahan gula',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Mangga Strawberry',
                'description' => 'Kombinasi segar jus mangga dan strawberry',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Mangga Kiwi',
                'description' => 'Perpaduan manis jus mangga dengan kiwi yang segar',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Naga Mangga',
                'description' => 'Kombinasi jus buah naga dan mangga yang menyegarkan',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'dragon-fruit.jpg',
            ],
            [
                'name' => 'Mangga Sirsak',
                'description' => 'Perpaduan jus mangga dan sirsak yang kaya nutrisi',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Kiwi',
                'description' => 'Jus kiwi segar kaya vitamin C',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Berry Mix',
                'description' => 'New menu 2024!! Smoothie blueberry dan strawberry',
                'price' => 25000,
                'category_id' => $smoothieCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'strawberry.jpg',
            ],
            [
                'name' => 'Strawberry',
                'description' => 'Jus strawberry segar. Please add NOTE kalau mau pakai MILK',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'strawberry.jpg',
            ],
            [
                'name' => 'Strawberry Banana',
                'description' => 'Kombinasi jus strawberry dan pisang yang lezat',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'strawberry.jpg',
            ],
            [
                'name' => 'Naga Strawberry',
                'description' => 'Perpaduan jus buah naga dan strawberry',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'dragon-fruit.jpg',
            ],
            [
                'name' => 'Naga Merah',
                'description' => 'Jus buah naga merah segar kaya antioksidan',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'dragon-fruit.jpg',
            ],
            [
                'name' => 'Melon',
                'description' => 'Jus melon segar dan menyegarkan',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Semangka Nanas',
                'description' => 'Kombinasi jus semangka dan nanas yang menyegarkan',
                'price' => 22000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Markisa Jeruk',
                'description' => 'Perpaduan jus markisa dan jeruk yang segar',
                'price' => 22000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'lemon-juice.jpg',
            ],
            [
                'name' => 'Terong Belanda',
                'description' => 'Jus terong belanda segar kaya antioksidan',
                'price' => 22000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Jeruk',
                'description' => 'Jus jeruk segar kaya vitamin C',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'lemon-juice.jpg',
            ],
            [
                'name' => 'Martabe',
                'description' => 'Jus markisa dan terong belanda yang menyegarkan',
                'price' => 22000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Wortel Susu',
                'description' => 'Jus wortel dengan tambahan susu yang lezat',
                'price' => 22000,
                'category_id' => $vegetableCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Tomat Wortel',
                'description' => 'Kombinasi jus tomat dan wortel yang kaya nutrisi',
                'price' => 22000,
                'category_id' => $vegetableCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Wortel Jeruk',
                'description' => 'Perpaduan jus wortel dan jeruk yang menyegarkan',
                'price' => 22000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Apel Fuji',
                'description' => 'Jus apel fuji segar tanpa tambahan gula',
                'price' => 22000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Sirsak',
                'description' => 'Jus sirsak segar kaya nutrisi',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Wortel',
                'description' => 'Jus wortel segar kaya vitamin A',
                'price' => 18000,
                'category_id' => $vegetableCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Naga Sirsak',
                'description' => 'Kombinasi jus buah naga dan sirsak yang menyegarkan',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'dragon-fruit.jpg',
            ],
            [
                'name' => 'Guava',
                'description' => 'Jus jambu biji segar kaya vitamin',
                'price' => 22000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Papaya Milk',
                'description' => 'Taiwanese PAPAYA MILK yang lezat',
                'price' => 22000,
                'category_id' => $smoothieCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Nanas',
                'description' => 'Jus nanas segar kaya enzim bromelain',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Tomat',
                'description' => 'Jus tomat segar kaya likopen',
                'price' => 18000,
                'category_id' => $vegetableCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Semangka',
                'description' => 'Jus semangka segar dan menyegarkan',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Sunkist',
                'description' => 'Jus jeruk sunkist segar dan manis',
                'price' => 22000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'lemon-juice.jpg',
            ],
            [
                'name' => 'Kesturi Kiamboy',
                'description' => 'Mencegah batuk dan sakit tenggorokan. Detox paru-paru untuk active smoker',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Timun',
                'description' => 'Jus timun segar yang menyegarkan',
                'price' => 18000,
                'category_id' => $vegetableCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Nutty Banana',
                'description' => 'Banana + Ground Almonds + Honey',
                'price' => 30000,
                'category_id' => $smoothieCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'green-smoothie.jpg',
            ],
            [
                'name' => 'Jujuberry Yogurt',
                'description' => 'Jujube + Strawberry + Dried Cranberry',
                'price' => 30000,
                'category_id' => $smoothieCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'strawberry.jpg',
            ],
            [
                'name' => 'Alpokat Milo',
                'description' => 'Jus alpokat dengan tambahan milo yang lezat',
                'price' => 25000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'green-smoothie.jpg',
            ],
            [
                'name' => 'Alpokat Murni',
                'description' => 'Juice alpokat murni, tidak memakai gula es susu dll, murni alpokat',
                'price' => 25000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'green-smoothie.jpg',
            ],
            [
                'name' => 'Belimbing',
                'description' => 'Jus belimbing segar yang menyegarkan',
                'price' => 18000,
                'category_id' => $fruitCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'mango.jpg',
            ],
            [
                'name' => 'Sawi Nanas',
                'description' => 'Kombinasi jus sawi dan nanas yang kaya nutrisi',
                'price' => 22000,
                'category_id' => $mixCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'green-smoothie.jpg',
            ],
            [
                'name' => 'Green Smoothie',
                'description' => 'Kale + nanas + banana',
                'price' => 25000,
                'category_id' => $smoothieCategory->id,
                'stock' => 50,
                'is_active' => true,
                'image' => 'green-smoothie.jpg',
            ],
        ];

        // Masukkan data produk ke database
        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['name' => $productData['name']],
                [
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'category_id' => $productData['category_id'],
                    'stock' => $productData['stock'],
                    'is_active' => $productData['is_active'],
                    'image' => $productData['image'],
                ]
            );
            
            // Add some random ratings to products
            $this->addRandomRatings($product);
        }
    }
    
    /**
     * Add random ratings to a product
     *
     * @param Product $product
     * @return void
     */
    private function addRandomRatings(Product $product)
    {
        // Get some users to add ratings
        $users = User::where('role', 'customer')->take(5)->get();
        
        if ($users->isEmpty()) {
            // If no customers exist, create a few
            for ($i = 1; $i <= 5; $i++) {
                $users[] = User::create([
                    'name' => 'Customer ' . $i,
                    'email' => 'customer' . $i . '@example.com',
                    'password' => bcrypt('password123'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]);
            }
        }
        
        // Number of ratings to add (random between 0 and 5)
        $numRatings = rand(0, 5);
        
        for ($i = 0; $i < $numRatings; $i++) {
            $user = $users->random();
            
            // Check if this user already rated this product
            $existingRating = Rating::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
                
            if (!$existingRating) {
                Rating::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Ratings between 3 and 5 stars
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