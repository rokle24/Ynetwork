<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(){
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required',Password::min(8)]
        ]);

        if(!Auth::attempt($attributes, true)){
            throw ValidationException::withMessages([
                'password' => 'Provided email or password are incorrect.'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/for-you');
    }

    public function destroy(){
        Auth::logout();
        return redirect('/');
    }
}
