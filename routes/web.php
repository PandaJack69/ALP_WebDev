<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MerchantProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MercController;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Default landing page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/merchant-dashboard', [MercController::class, 'index'], function() {
    return view('merchant-dashboard');
})->middleware(['auth', 'verified'])->name('merchant-dashboard');

// Routes that require authentication
Route::middleware('auth')->group(function () {

    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/create-merchant', [ProfileController::class, 'createMerchant'])->name('profile.create-merchant');

    Route::post('/profile/switch-role-merchant', [ProfileController::class, 'switchRoleMerchant'])->name('profile.switch-role-merchant');

    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.updatePicture');

    // Merchant profile management routes
    Route::get('/merchant-profile', [MerchantProfileController::class, 'edit'])->name('merchant-profile.merchant-edit');

    Route::patch('/merchant-profile', [MerchantProfileController::class, 'update'])->name('merchant-profile.update');
    
    Route::delete('/merchant-profile', [MerchantProfileController::class, 'destroy'])->name('merchant-profile.destroy');

    Route::post('/profile/switch-role-user', [ProfileController::class, 'switchRoleUser'])->name('profile.switch-role-user');
    
    // Store-related routes (for browsing stores and selecting items)
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');

    

    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');

    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');

    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');

    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');

    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');

    //merchant store routes
    //create
    Route::get('/merchant-store/create', [StoreController::class, 'create'])->name('merchant_store.create');
	Route::post('/merchant-store/{store}/add-item', [StoreController::class, 'addItem'])->name('merchant_store.add_item');

    //read
	Route::get('/merchant-store/{store}/show', [StoreController::class, 'show'])->name('merchant_store.show');

    //update
	Route::put('/merchant-store/{store}', [StoreController::class, 'update'])->name('merchant_store.update');
	Route::get('/merchant-store/{store}/edit', [StoreController::class, 'edit'])->name('merchant_store.edit');

    //delete
	Route::delete('/merchant-store/item/{item}', [StoreController::class, 'delete'])->name('merchant_store.delete_item');

    Route::delete('/merchant-store/{id}', [StoreController::class, 'destroy'])->name('merchant_store.delete');

    Route::put('/merchant-password', [MerchantProfileController::class, 'updateMerchantPassword'])->name('merchant-password.update');
    
    // Cart-related routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

    // Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');

    Route::post('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');

    Route::delete('/cart/destroy/{cartItemId}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/cart/checkout/success', function () {
        return view('cart.checkout.success');
    })->name('checkout.success');

    // Order-related routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Route to show a single store's details
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('store.show');

    
    // Route::middleware(['auth', 'redirect.role'])->group(function () {
    //     Route::get('/merchant-dashboard', [MercController::class, 'dashboard'])->name('merchant-dashboard');

    //     Route::get('/user-dashboard', [DashboardController::class, 'dashboard'])->name('user-dashboard');
    // });
    
    Route::get('/category/{id}', [DashboardController::class, 'showCategory'])->name('category.show');

    // Route for viewing stores by category
    Route::get('/view-all/{categoryId}', [DashboardController::class, 'viewAll'])->name('view.all');

    

});

// Authentication routes
require __DIR__.'/auth.php';

