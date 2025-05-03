<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $user = Auth::guard('admin')->user();

            if ($user->role == 'admin') {
                return redirect()->route('home')->with('success', 'Login berhasil!');
            } else {
                return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout(); 
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role user
        ]);

        Auth::guard('admin')->login($admin); 

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Selamat datang!');
    }
}
