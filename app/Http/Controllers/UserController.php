<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect(route('user.dashboard'));
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->orWhere('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->remember);
            return redirect()->intended(route('user.dashboard'));
        }
        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        return view('users.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
