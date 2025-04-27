<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PagesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/increment', [CartController::class, 'incrementCart'])->name('cart.increment');
Route::post('/cart/decrement', [CartController::class, 'decrementCart'])->name('cart.decrement');
Route::post('/shippingdetail', [CartController::class, 'store'])->name('order.store');
Route::get('/search', [PagesController::class, 'search'])->name('product.search');

