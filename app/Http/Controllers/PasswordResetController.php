<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class PasswordResetController extends Controller
{
    public function resetRequest()
    {
        return view('auth.password-reset');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors([['email' => "We can't find a user with that e-mail address."]]);
        }
        $token = Password::createToken($user);

        Mail::to($user->email)->send(new ResetPassword($user, $token));

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function reset()
    {
        return view('auth.passwordReset', [
            'token' => request()->query('token'),
            'email' => request()->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect('/')->with('success', 'Your password has been reset.')
            : back()->withErrors(['email' => __($status)]);
    }
}
