<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function registform(){
        return view('admin.storeAdmin');
    }
    public function register(Request $request)
    {

    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $User = new User([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'admin'
    ]);
    
    $User->save();

    return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    public function loadadmin()
    {
        $User = User::all()->where('role', 'admin');
        Debugbar::debug($User);
        return response()->json($User);
    }
    public function editadmin($id)
        {
            $product = User::find($id);
    
            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm.');
            }
            return response()->json($product);
        }
        public function updateadmin(Request $request, $id)
        {
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone_number' => '',
                'address' => '',
            ]);

            $product = User::find($id);
    
            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm.');
            }
            $product->first_name = $request->get('first_name');
            $product->last_name = $request->get('last_name');
            $product->email  = $request->get('email');
            $product->phone_number = $request->get('phone_number');
            $product->address = $request->get('address');

            $product->save();
            return view('admin.storeAdmin')->with('success', 'Cập nhật thành công');
        }
    
}
