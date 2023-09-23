<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function index(){
        return view('admin.showUser');
    }
    public function show(){
        $User = User::all()->where('role', 'user');
        Debugbar::debug($User);
        return response()->json($User);
    }
}
