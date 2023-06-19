<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
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
// Ruta que carga la vista de login
Route::get('/', function () {
    return view('login');
})->name('home');
// Ruta que carga la vista de registro
Route::get('/register', function () {
    return view('register');
});
Route::middleware(['auth', 'loadSections'])->group(function () {
    // Ruta que carga la vista de welcome
    Route::get('welcome', function () {
        return view('welcome');
    })->name('welcome');
});
Route::middleware(['cors'])->group(function () {
    // Ruta para Logearse 
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Ruta para Registrarse
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    // Ruta para Deslogearse 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/csrf-token', function() {
    return csrf_token();
});