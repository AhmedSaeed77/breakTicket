<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\Auth\LoginRequest;

class AuthService
{

    public function _login()
    {
        return view('dashboard.site.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $rememberMe = $request->remember_me == 'on';
        if(auth()->attempt($credentials, $rememberMe))
        {
            return redirect()->route('/');
        }
        else
        {
            return redirect()->route('auth.login')->with(['error' => __('dashboard.Incorrect email or password')]);
        }
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('auth.login');
    }

}
