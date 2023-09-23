<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/'); 
        } else {
            return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu.');
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function registerForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    // Validate form data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    // Create a new user
    $User = new User([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);
    
    $User->save();

    // Redirect to login page with a success message
    return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
}
    
}
