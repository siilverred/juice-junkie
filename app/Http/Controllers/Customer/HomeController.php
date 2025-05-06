<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\Rating;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->with('ratings') // Eager load ratings for average calculation
            ->latest()
            ->take(6)
            ->get();
            
        $categories = Category::withCount('products')->get();
        $testimonials = Testimonial::where('is_approved', true)
            ->with('user')
            ->latest()
            ->take(3)
            ->get();
            
        return view('customer.home', compact('featuredProducts', 'categories', 'testimonials'));
    }

    public function products(Request $request)
    {
        $query = Product::where('is_active', true);
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->with('ratings') // Eager load ratings for average calculation
            ->latest()
            ->paginate(12);
        $categories = Category::all();
        
        // Make sure we have products
        if ($products->isEmpty() && !$request->has('search') && !$request->has('category')) {
            // Run the seeder if no products exist
            \Artisan::call('db:seed', ['--class' => 'ProductSeeder']);
            
            // Fetch products again
            $products = Product::where('is_active', true)
                ->with('ratings')
                ->latest()
                ->paginate(12);
        }
        
        // Check if products have ratings, if not, run the rating seeder
        $hasRatings = Rating::count() > 0;
        if (!$hasRatings) {
            try {
                // Create a new seeder instance and run it
                $seeder = new \Database\Seeders\RatingSeeder();
                $seeder->run();
                
                // Refresh the products with their new ratings
                $products = Product::where('is_active', true)
                    ->with('ratings')
                    ->latest()
                    ->paginate(12);
            } catch (\Exception $e) {
                // Log the error but continue
                \Log::error('Error generating ratings: ' . $e->getMessage());
            }
        }
        
        return view('customer.products', compact('products', 'categories'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->load('ratings.user');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('ratings') // Eager load ratings for related products
            ->take(4)
            ->get();
            
        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }
}