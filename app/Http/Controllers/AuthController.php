<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    public function loginForm() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        $login = Auth::attempt($request->only('email','password'));

        if($login) return redirect('/products');

        return back();
    }

    public function registrationForm() {
        return view('/register');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    // ✅ Added register method
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'designation' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'designation' => $validated['designation'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user));

        return redirect('/')->with('success', 'Registration successful! Please check your email.');
    }
}
