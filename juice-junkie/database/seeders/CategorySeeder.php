<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Fruit Juices',
                'description' => 'Jus buah segar dengan berbagai pilihan rasa'
            ],
            [
                'name' => 'Vegetable Juices',
                'description' => 'Jus sayuran segar kaya nutrisi'
            ],
            [
                'name' => 'Mix Juices',
                'description' => 'Kombinasi jus buah dan sayur'
            ],
            [
                'name' => 'Smoothies',
                'description' => 'Smoothie kental dengan berbagai pilihan rasa'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description']
                ]
            );
        }
    }
}
