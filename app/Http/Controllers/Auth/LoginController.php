<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    private $token;

    public function __construct()
    {
        $this->middleware('guest')->only('login');
        $this->middleware('jwt.auth')->only('logout');   
    }

    protected function attemptLogin(Request $request)
    {
        $this->token = auth()->attempt($this->credentials($request));
        return (bool) $this->token;
    }

    protected function sendLoginResponse(Request $request)
    {
        return response()->json([
            'token' => $this->token,
            'user' => auth()->user(),
            'flash' => 'You are now signed in'
        ]);
    }

    protected function sendFailLoginResponse(Request $request)
    {
        return response()->json(['flash' => trans('auth.failed')]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['flash' => 'You have been signed out']);
    }
}