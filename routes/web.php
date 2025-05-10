<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SexuallyDiseaseController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckVerifyStatus;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware([CheckVerifyStatus::class, 'auth', 'verified'])->name('dashboard');

Route::middleware([CheckVerifyStatus::class, 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([CheckVerifyStatus::class, 'auth'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::patch('/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
});

Route::middleware([CheckVerifyStatus::class, 'auth'])->prefix('sexually-disease')->group(function () {
    Route::get('/', [SexuallyDiseaseController::class, 'index'])->name('sexually-disease.index');
    Route::get('/create', [SexuallyDiseaseController::class, 'create'])->name('sexually-disease.create');
    Route::post('/', [SexuallyDiseaseController::class, 'store'])->name('sexually-disease.store');
    Route::get('/{sexuallyDisease}', [SexuallyDiseaseController::class, 'show'])->name('sexually-disease.show');
});


require __DIR__ . '/auth.php';
