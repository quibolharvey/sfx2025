<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify($id, Request $request)
{
    $user = \App\Models\User::findOrFail($id);

    if ($user->email_validated_at) {
        return redirect('/login')->with('info', 'Email already verified.');
    }

    $user->email_validated_at = now();
    $user->save();

    return redirect('/login')->with('success', 'Email successfully verified. You can now log in.');
}

}
