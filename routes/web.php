<?php

use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\ShopController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group([
    'prefix' => 'shop',
    'as' => 'shop.',
    'middleware' => ['auth','verified']
],function () {
    

    //product routes
    Route::group([
        'as' => 'product.',
        'prefix' => 'product',    
    ],function () {
        Route::get('/', [ShopController::class, 'listProducts'])->name('list');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{product}/edit', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}/delete', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('{product}/mark-as-top', [ProductController::class, 'markAsTop'])->name('mark-as-top');
    });

    //category routes
    Route::group([
        'as' => 'category.',
        'prefix' => 'category',    
    ],function () {
        Route::get('/', [ShopController::class, 'listCategories'])->name('list');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/create', [CategoryController::class, 'store'])->name('store');
        Route::get('/search/{search}', [CategoryController::class, 'search'])->name('search');
        Route::get('/{category}', [ShopController::class, 'listCategoryProducts'])->name('show');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
