<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyEmail;

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

    // ✅ Enhanced register method with email verification
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

        // ✅ Create signed URL valid for 60 minutes
        $verificationUrl = URL::temporarySignedRoute(
            'verification.validate', now()->addMinutes(60), ['id' => $user->id]
        );

        // ✅ Send verification email
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));

        return redirect('/')->with('success', 'Registration successful! Please check your email to verify.');
    }
}
