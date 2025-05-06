<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->withCount('orders');
        
        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Sort results
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        $customers = $query->paginate(10);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }
        
        $user->load('orders');
        return view('admin.customers.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }
        
        $customer = Customer::where('user_id', $user->id)->first();
        
        return view('admin.customers.edit', compact('user', 'customer'));
    }
    
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'address' => $request->address,
            ]
        );
        
        if ($customer->exists) {
            $customer->update([
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }
        
        return redirect()->route('admin.customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }
}