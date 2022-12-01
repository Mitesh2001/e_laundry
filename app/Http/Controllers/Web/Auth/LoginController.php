<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest as LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $loginRequest)
    {
       $credentials = $loginRequest->only('email', 'password');

       if(Auth::attempt($credentials)){
            Auth::attempt(['email' => $loginRequest->emailo, 'password' => $loginRequest->password]);
            return redirect()->intended();
       }
       return back()->withErrors('password', 'Invalid Credential')->withInput();
    }

    public function logout()
    {
        $user = auth()->user();
        Auth::logout($user);
        return redirect()->route('login');
    }
}
