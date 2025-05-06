<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        // Check for default credentials and create if they don't exist
        if ($this->email === 'admin@juicejunkie.com' || $this->email === 'customer@example.com') {
            $this->ensureDefaultUsersExist();
        }

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
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
            
            Log::info('Default users created/updated successfully in LoginRequest');
        } catch (\Exception $e) {
            Log::error('Error creating default users in LoginRequest', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}