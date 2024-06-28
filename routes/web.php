<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\StatisticsController;

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


Auth::routes(['verify' => true]);
Auth::routes();
Route::get('/password/change', [ChangePasswordController::class, 'show'])
    ->name('password.change.show');
Route::post('/password/change', [ChangePasswordController::class, 'store'])
    ->name('password.change.store');


Route::view('teste', 'template.layout');


Route::resource('orders', OrderController::class)->middleware('auth');


Route::middleware('can:funcionario')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/home', [TshirtImageController::class, 'index'])->name('home');

    Route::get('/', [TshirtImageController::class, 'index'])->name('root');


    Route::resource('customers', CustomerController::class)->middleware('auth');
    Route::delete('customers/{customer}/foto', [CustomerController::class, 'destroy_foto'])
        ->name('customers.foto.destroy')->middleware('auth');


    // Route que devolve uma imagem privada
    Route::get('tshirt_images_private/{image}', function ($image) {
        $file = storage_path('app/tshirt_images_private/' . $image);
        return response()->file($file);
    })->name('tshirt_images.private');

    Route::resource('tshirt_images', TshirtImageController::class);
    Route::delete('tshirt_images/{id}', 'TshirtImageController@destroy');
    Route::post('tshirt_images/{id}', 'TshirtImageController@update');

    // Gestao de categories, colors e prices (so administradores)
    Route::middleware('can:administrate')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('colors', ColorController::class);
        Route::get('prices', [PriceController::class, 'show'])->name('prices.show');
        Route::get('prices/edit', [PriceController::class, 'edit'])->name('prices.edit');
        Route::put('prices', [PriceController::class, 'update'])->name('prices.update');
        Route::resource('statistics', StatisticsController::class);
        Route::resource('users', UserController::class)->middleware('auth');
        Route::resource('blockers', BlockController::class)->middleware('auth');
        Route::delete('users/{user}/foto', [UserController::class, 'destroy_foto'])
            ->name('users.foto.destroy')->middleware('auth');
    });

    // Cart routes
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add'); // add item to cart
    Route::delete('cart/{cartIndex}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // remove item from cart
    Route::get('cart', [CartController::class, 'show'])->name('cart.show'); // show cart items
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy'); // clear cart
    Route::get('cart/edit/{cartIndex}', [CartController::class, 'edit'])->name('cart.edit'); // view para editar
    Route::put('cart/{cartIndex}', [CartController::class, 'update'])->name('cart.update'); // editar item
    Route::middleware('can:completeOrder')->group(function () {
        Route::post('cart', [CartController::class, 'store'])->name('cart.store'); // confirm order
        Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // clear cart
    });

    Route::get('/download-pdf/{order}', [OrderController::class, 'downloadPDF'])->name('download.pdf')->middleware('auth');
});


