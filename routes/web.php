<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/inventario', [ProductController::class, 'index'])->name('inventario');
    Route::post('/inventario', [ProductController::class, 'store']);
    Route::get('/ventas', [SaleController::class, 'index']);
    Route::post('/ventas', [SaleController::class, 'store']);
    Route::get('/ventas', [SaleController::class, 'index']);
    Route::post('/carrito/agregar', [SaleController::class, 'addToCart']);
    Route::post('/carrito/eliminar/{id}', [SaleController::class, 'removeFromCart']);
    Route::post('/ventas/confirmar', [SaleController::class, 'checkout']);
    Route::get('/ticket/{id}', [SaleController::class, 'ticket'])->name('ticket');
    Route::get('/ticket/{id}/pdf', [SaleController::class, 'ticketPdf'])->name('ticket.pdf');


});

require __DIR__.'/auth.php';
