<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    /**
     * Display the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a new user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            // "name" is used as the username field
            'name'     => 'required|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Logged out successfully.');
    }
}
