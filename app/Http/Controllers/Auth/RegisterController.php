<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
        {
            $data = request()->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'firstname' => 'required|max:40',
                'lastname' => 'required|max:40',
            ]);

            $user = User::create($data);
            $token = auth()->attempt(request()->only(['email', 'password']));
            $flash = 'Your account has been created';

            return response()->json(compact('user','token', 'flash'));
        }
}