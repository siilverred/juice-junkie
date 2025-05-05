<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct()
    {
        // Only require auth for store and rateProduct methods
        $this->middleware('auth')->only(['store', 'rateProduct']);
    }

    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(9);
            
        return view('customer.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10|max:500',
        ]);

        Testimonial::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Testimonial berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function rateProduct(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return redirect()->back()->with('success', 'Terima kasih atas penilaian Anda.');
    }
}