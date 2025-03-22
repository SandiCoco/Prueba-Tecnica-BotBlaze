<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/productos');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);




// Ruta de productos protegida (requiere estar autenticado)
Route::get('/productos', [WebProductController::class, 'index'])->middleware('auth');