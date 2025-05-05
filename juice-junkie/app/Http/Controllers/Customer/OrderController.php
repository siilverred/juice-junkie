<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function cart()
    {
        $cartItems = session()->get('cart', []);
        $totalAmount = 0;
        
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        return view('customer.cart', compact('cartItems', 'totalAmount'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart)
            ]);
        }
        
        return redirect()->route('cart')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart)
            ]);
        }
        
        return redirect()->route('cart')
            ->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if ($request->ajax()) {
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
                
                return response()->json([
                    'success' => true,
                    'cartCount' => count($cart)
                ]);
            }
            
            return response()->json([
                'success' => false
            ]);
        } else {
            foreach ($request->quantity as $id => $quantity) {
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = $quantity;
                }
            }
            
            session()->put('cart', $cart);
            
            return redirect()->route('cart')
                ->with('success', 'Keranjang berhasil diperbarui');
        }
    }

    public function checkout()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang belanja kosong');
        }
        
        $totalAmount = 0;
        
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        return view('customer.checkout', compact('cartItems', 'totalAmount'));
    }

    public function placeOrder(OrderRequest $request)
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang belanja kosong');
        }
        
        $totalAmount = 0;
        
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);
            
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                
                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }
            
            DB::commit();
            
            session()->forget('cart');
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('items.product');
        return view('customer.order-detail', compact('order'));
    }
}
