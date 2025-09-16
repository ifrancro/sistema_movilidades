<?php

use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas de autenticación
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de vehículos
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);

    // Gestión de rutas
    Route::prefix('routes')->name('routes.')->group(function () {
        Route::get('/', [App\Http\Controllers\RouteController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\RouteController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\RouteController::class, 'store'])->name('store');
        Route::get('/{route}', [App\Http\Controllers\RouteController::class, 'show'])->name('show');
        Route::get('/{route}/edit', [App\Http\Controllers\RouteController::class, 'edit'])->name('edit');
        Route::put('/{route}', [App\Http\Controllers\RouteController::class, 'update'])->name('update');
        Route::delete('/{route}', [App\Http\Controllers\RouteController::class, 'destroy'])->name('destroy');
    });

    // Gestión de dueños
    Route::resource('owners', \App\Http\Controllers\OwnerController::class);



    // Sistema de alertas
    Route::prefix('alerts')->name('alerts.')->group(function () {
        Route::get('/', function () {
            return view('alerts.index');
        })->name('index');
    });

    // Reportes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () {
            return view('reports.index');
        })->name('index');
    });

    // Perfil de usuario
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // La ruta de logout ya está definida arriba
});
