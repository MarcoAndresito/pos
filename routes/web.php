<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\librosController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/test', function () {
        return Inertia::render('test');
    });

    Route::resource('category', CategoryController::class);

    Route::get('product', [ProductController::class, 'index'])->name('product.index');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');
    Route::put('product', [ProductController::class, 'update'])->name('product.update');
    Route::delete('product', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('sale/create', [SaleController::class, 'create'])->name('sale.create');
    Route::post('sale', [SaleController::class, 'store'])->name('sale.store');
    Route::get('sale/{sale}', [SaleController::class, 'show'])->name('sale.show');

    Route::resource('client', ClientController::class);
});

Route::get('/saludar', function () {
    return '!Hola Munddo¡';
})->name('apiLibros.saludar');

Route::get('/v1/libros', [librosController::class, 'obtenerLibros'])
    ->name('apiLibros.listar');

Route::get('/v1/libros/{id}', [librosController::class, 'obtenerLibro'])
    ->name('apiLibros.obtener');

Route::get('/v2/libros', [librosController::class, 'obtenerLibrosv2'])
    ->name('apiLibros.listarv2');
