<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return redirect('/login');
});



Route::middleware('auth')->group(function () {

    /* Perfil */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/ventas/crear', [SaleController::class, 'create'])
        ->name('ventas.create');

    Route::post('/carrito/agregar', [SaleController::class, 'addToCart']);
    Route::post('/carrito/eliminar/{id}', [SaleController::class, 'removeFromCart']);
    Route::post('/ventas/confirmar', [SaleController::class, 'checkout']);

    /* Ticket */
    Route::get('/ticket/{id}', [SaleController::class, 'ticket'])
        ->name('ticket.show');

    Route::get('/ticket/{id}/pdf', [SaleController::class, 'ticketPdf'])
        ->name('ticket.pdf');

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'owner') {
        return redirect()->route('dashboard.owner');
    }

        return redirect()->route('ventas.create');
    })->middleware('auth')->name('dashboard');

    Route::get('/password/change', fn () => view('auth.change-password'))
        ->name('password.change');

    Route::post('/password/change', [ProfileController::class, 'updatePassword'])
        ->name('password.update');
});

Route::middleware(['auth', 'owner'])->group(function () {

    /* Dashboard */
    Route::get('/dashboard/owner', [DashboardController::class, 'index'])
        ->name('dashboard.owner');

    /* Inventario */
    Route::get('/inventario', [ProductController::class, 'index'])
        ->name('inventario');

    Route::post('/inventario', [ProductController::class, 'store']);

    /* Historial de ventas */
    Route::get('/ventas', [SaleController::class, 'index'])
        ->name('ventas.index');

    Route::get('/usuarios', [UserController::class, 'index'])
        ->name('usuarios.index');

    Route::get('/usuarios/crear', [UserController::class, 'create'])
        ->name('usuarios.create');

    Route::post('/usuarios', [UserController::class, 'store'])
        ->name('usuarios.store');
});



require __DIR__.'/auth.php';
