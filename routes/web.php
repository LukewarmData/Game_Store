<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Landing page to select login type
Route::get('/login-select', function () {
    return view('auth.select');
})->name('login.select');

// Public Routes (Browsing)
// الصفحة الرئيسية (استعراض آخر المنتجات)
Route::get('/', [HomeController::class, 'index'])->name('home');

// روابط تسجيل الدخول والإنشاء (للمستخدم العادي)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// روابط الإدارة (Admin)
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// روابط المنتجات العامة (التصفح والعرض)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show')
    ->where('product', '[0-9]+');

// روابط محمية (تطلب تسجيل الدخول أولاً)
Route::middleware('auth')->group(function () {
    
    // روابط السلة (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    // روابط الدفع والطلبات (Checkout)
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success/{order}', [CartController::class, 'success'])->name('checkout.success');
    
    // روابط لوحة التحكم (خاصة بالأدمن فقط)
    Route::middleware([App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});
