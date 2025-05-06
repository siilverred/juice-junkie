<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        try {
            // Check for default credentials and create if they don't exist
            if ($request->email === 'admin@juicejunkie.com' || $request->email === 'customer@example.com') {
                $this->ensureDefaultUsersExist();
            }
            
            // Check if user exists
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors([
                    'email' => 'No user found with this email address.',
                ])->withInput($request->only('email', 'remember'));
            }
            
            // Attempt authentication
            if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->withInput($request->only('email', 'remember'));
            }
            
            $request->session()->regenerate();
            
            // Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // Redirect regular users to home page
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            Log::error('Login error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'email' => 'An error occurred during login: ' . $e->getMessage(),
            ])->withInput($request->only('email', 'remember'));
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    /**
     * Ensure default users exist in the database.
     */
    private function ensureDefaultUsersExist()
    {
        try {
            // Check if the role column exists
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
            
            Log::info('Default users created/updated successfully');
        } catch (\Exception $e) {
            Log::error('Error creating default users', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}