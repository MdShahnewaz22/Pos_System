<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ModuleMakerController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\ProductdetailController;

//don't remove this comment from route namespace

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'loginPage'])->name('home')->middleware('AuthCheck');

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('clear-compiled');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    Artisan::call('optimize');
    session()->flash('message', 'System Updated Successfully.');

    return redirect()->route('home');
});

Route::group(['as' => 'auth.'], function () {
    Route::get('/login', [LoginController::class, 'loginPage'])->name('login2')->middleware('AuthCheck');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'AdminAuth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::match(['get', 'post'], '/module-make', [ModuleMakerController::class, 'index'])->name('moduleMaker');

    Route::resource('admin', AdminController::class);
    Route::get('admin/{id}/status/{status}/change', [AdminController::class, 'changeStatus'])->name('admin.status.change');

    // for role
    Route::resource('role', RoleController::class);

    // for permission entry
    Route::resource('permission', PermissionController::class);

	// for Product
	Route::resource('product', ProductController::class);
	Route::get('product/{id}/status/{status}/change', [ProductController::class, 'changeStatus'])->name('product.status.change');
	// for Color
	Route::resource('color', ColorController::class);
	Route::get('color/{id}/status/{status}/change', [ColorController::class, 'changeStatus'])->name('color.status.change');
    
	// for Size
	Route::resource('size', SizeController::class);
	Route::get('size/{id}/status/{status}/change', [SizeController::class, 'changeStatus'])->name('size.status.change');
	// for Unit
	Route::resource('unit', UnitController::class);
	Route::get('unit/{id}/status/{status}/change', [UnitController::class, 'changeStatus'])->name('unit.status.change');
    
    // for productdetail
	Route::resource('productdetail', ProductdetailController::class);
	Route::get('productdetail/{id}/status/{status}/change', [ProductdetailController::class, 'changeStatus'])->name('productdetail.status.change');
    

	//don't remove this comment from route body
});