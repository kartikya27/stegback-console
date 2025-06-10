<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Kartikey\PanelPulse\Models\User;

class AuthController extends Controller
{

    public function login()
    {
        return view('PanelPulse::admin-login');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function loggedIn_PostRequest(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Auth::login(Auth::user());

            if (auth()->user()->email === env('ADMIN_EMAIL')) {
                return redirect()->route('admin');
            }
            return redirect()->intended('/');
        } else {
            return redirect()->route('login')->with('warning', 'Email ID or Password does not match our records.');
        }
    }
}
