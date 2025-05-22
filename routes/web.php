<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::put('/user/address', [UserController::class, 'updateAddress'])->name('user.updateAddress');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    //Categories
    Route::get('/admin/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/categories', [AdminController::class, 'categoriesIndex'])->name('admin.categories.view');
    Route::get('/admin/categories/data', [AdminController::class, 'getCategoriesData'])->name('admin.categories.data');
    Route::get('/admin/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'softDeleteCategory'])->name('admin.categories.delete');
    Route::post('/admin/categories/{id}/restore', [AdminController::class, 'restoreCategory'])->name('admin.categories.restore');
    //Products
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products', [AdminController::class, 'productsIndex'])->name('admin.products.view');
    Route::get('/admin/products/data', [AdminController::class, 'getproductsData'])->name('admin.products.data');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editproduct'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminController::class, 'updateproduct'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminController::class, 'softDeleteproduct'])->name('admin.products.delete');
    Route::post('/admin/products/{id}/restore', [AdminController::class, 'restoreproduct'])->name('admin.products.restore');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.view');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::get('/checkout', [CartController::class, 'index'])->name('checkout');
