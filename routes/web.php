<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportContoller;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\CustomerController;

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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/get-item-price/{id}', [OrderController::class, 'getItemPrice'])->name('orders.getItemPrice')->middleware('auth');
Route::get('/search-customers', [CustomerController::class, 'searchCustomers'])->name('search.customers')->middleware('auth');

Route::fallback(function () {
    return redirect()->route('admin.index'); // Redirect to the 'index' route
});

Route::middleware('guest')->group(function () {
    Route::view('/login/page', 'auth.login')->name('login.view');
    Route::view('/register/page', 'auth.register')->name('register.view');
    Route::post('/register', [AuthController::class, 'createUser'])->name('admin.register');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/search/items', [MenuController::class, 'searchItems'])->name('search.items');
        Route::view('/dashboard', 'admin.index')->name('admin.index');
        Route::view('create/user', 'admin.trashed.users.create')->name('create.user');
        Route::post('add/user', [AuthController::class, 'createUser'])->name('add.user');
        Route::get('edit/user/{id}', [AuthController::class, 'editUser'])->name('edit.user');
        Route::put('update/user/{id}', [AuthController::class, 'updateUser'])->name('update.user');
        Route::delete('delete/user/{id}', [AuthController::class, 'deleteUser'])->name('delete.user');
        Route::get('show/user/{id}', [AuthController::class, 'showUser'])->name('show.user');
        Route::get('/users', [AuthController::class, 'allUsers'])->name('users.index')->middleware('admin');

        // Order Routes
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/search', [OrderController::class, 'search'])->name('orders.search');
            Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
            Route::get('/show/{id}', [OrderController::class, 'show'])->name('orders.show');
            Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
            Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
            Route::put('/update/{id}', [OrderController::class, 'update'])->name('orders.update');
            Route::delete('/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
            Route::get('/trashed', [OrderController::class, 'trashed'])->name('orders.trashed')->middleware('admin');
            Route::put('/restore/{id}', [OrderController::class, 'restore'])->name('orders.restore');
            Route::delete('/force-delete/{id}', [OrderController::class, 'forceDelete'])->name('orders.forceDelete');
            Route::get('show/trashed/{id}', [OrderController::class, 'showTrashed'])->name('orders.showTrashed')->middleware('admin');
            Route::get('/orders/{order}/receipt', [OrderController::class, 'showReceipt'])->name('orders.receipt');
        });

        // Menu Routes
        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('menu.index');
            Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
            Route::get('/show/{id}', [MenuController::class, 'show'])->name('menu.show');
            Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
            Route::put('/update/{id}', [MenuController::class, 'update'])->name('menu.update');
            Route::delete('/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
        });

        // Customer Routes
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
            Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
            Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customers.show');
            Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
            Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
            Route::get('/trashed', [CustomerController::class, 'trashed'])->name('customers.trashed');
            Route::delete('/force-delete/{id}', [CustomerController::class, 'forceDelete'])->name('customers.forceDelete');
            Route::put('/restore/{id}', [CustomerController::class, 'restore'])->name('customers.restore');
        });

        // Stock Routes
        Route::prefix('stocks')->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('stock.index');
            Route::get('/create', [StockController::class, 'create'])->name('stock.create');
            Route::get('/show/{id}', [StockController::class, 'show'])->name('stock.show');
            Route::post('/store', [StockController::class, 'store'])->name('stock.store');
            Route::get('/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
            Route::put('/update/{id}', [StockController::class, 'update'])->name('stock.update');
            Route::delete('/delete/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
        });

        // Report Routes
        Route::get('/reports', [ReportContoller::class, 'index'])->name('reports.index')->middleware('admin');
    });
