<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FreshController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\NutritionalController;
use App\Http\Controllers\userController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', [AuthController::class , 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin-addCategory', [CategoryController::class, 'index'])->name('admin.addCategory');
    Route::get('/admin-loadCategory', [CategoryController::class, 'loadCategory'])->name('admin.loadCategory');
    Route::get('/category-loadEdit/{id}', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('/admin-addCategory', [CategoryController::class, 'storeCategory'])->name('admin.storeCategory');
    Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('admin.deleteCategory');
    
    Route::get('/admin-product', [ProductController::class, 'index'])->name('admin.addProduct');
    Route::get('/admin-showProduct', [ProductController::class, 'show'])->name('admin.showProduct');
    Route::get('/load-product', [ProductController::class, 'loadProduct'])->name('admin.loadProduct');
    Route::post('/store-product', [ProductController::class, 'storeProduct'])->name('admin.storeProduct');
    Route::get('/Product-loadEdit/{id}', [ProductController::class, 'editProduct'])->name('admin.editProduct');
    Route::post('/admin-addProduct', [ProductController::class, 'storeProduct'])->name('admin.storeProduct');
    Route::put('/update-Product/{id}', [ProductController::class, 'updateProduct'])->name('admin.updateProduct');
    Route::delete('/delete-Product/{id}', [ProductController::class, 'deleteProduct'])->name('admin.deleteProduct');

    Route::get('/admin-store', [AdminController::class, 'registform'])->name('admin.addadmin');
    Route::get('/admin-showadmin', [AdminController::class, 'show'])->name('admin.showadmin');
    Route::get('/load-admin', [AdminController::class, 'loadadmin'])->name('admin.loadAdmin');
    Route::post('/store-admin', [AdminController::class, 'register'])->name('admin.storeadmin');
    Route::get('/admin-loadEdit/{id}', [AdminController::class, 'editadmin'])->name('admin.editadmin');
    Route::post('/admin-addadmin', [AdminController::class, 'storeadmin'])->name('admin.storeadmin');
    Route::put('/update-admin/{id}', [AdminController::class, 'updateadmin'])->name('admin.updateadmin');
    Route::delete('/delete-admin/{id}', [AdminController::class, 'deleteadmin'])->name('admin.deleteadmin');

    Route::get('/admin-showUser', [userController::class, 'show'])->name('admin.showUser');
    Route::get('/admin-Usertable', [userController::class, 'index'])->name('admin.table');
});

Route::get('/nutritional', [NutritionalController::class, 'index'])->name('nutritional');

Route::get('/fresh', [FreshController::class, 'index'])->name('fresh');

Route::get('/package', [PackageController::class, 'index'])->name('Package');

Route::get('/profile', [UserController::class, 'index'])->name('viewProfile');

Route::post('/search', [SearchController::class, 'index'])->name('search');
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('searchProducts');
Route::get('/filter/{id}', [SearchController::class, 'filter'])->name('filter');
Route::get('/detail/{id}', [SearchController::class, 'detail'])->name('detail');

Route::get('/cart-get', [CartController::class,'getCart'])->name('cart.get');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('update.cart');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCartItemCount'])->name('cart.count');
Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.total');

Route::get('/checkout', [OrderController::class, 'index'])->name('cart.checkout');
Route::post('/checkout-vnpay', [OrderController::class, 'vnpay_checkout'])->name('checkout');


Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register-user');
