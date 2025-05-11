<?php

use App\Http\Controllers\HelpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SexuallyDiseaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WomenDiseaseController;
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

Route::middleware([CheckVerifyStatus::class, 'auth'])->prefix('women-disease')->group(function () {
    Route::get('/', [WomenDiseaseController::class, 'index'])->name('women-disease.index');
    Route::get('/create', [WomenDiseaseController::class, 'create'])->name('women-disease.create');
    Route::post('/', [WomenDiseaseController::class, 'store'])->name('women-disease.store');
    Route::get('/{womenDisease}', [WomenDiseaseController::class, 'show'])->name('women-disease.show');
});

Route::middleware([CheckVerifyStatus::class, 'auth'])->prefix('help')->group(function () {

    //ortak
    Route::get('/{help}/message', [HelpController::class, 'showMessage'])->name('help-message.show');
    Route::post('/{help}/send-message', [HelpController::class, 'sendMessage'])->name('help-message.send');

    /// disease
    Route::get('/disease', [HelpController::class, 'diseaseIndex'])->name('help-disease.index');
    Route::get('/find-doctor', [HelpController::class, 'findDoctor'])->name('find-doctor.index');
    Route::post('/', [HelpController::class, 'storeHelp'])->name('help.store');
    Route::get('/{help}/show-disease', [HelpController::class, 'showHelpDisease'])->name('help-show-disease.index');

    ///doctor
    Route::get('/doctor', [HelpController::class, 'doctorIndex'])->name('help-doctor.index');
    Route::get('/{help}/show-doctor', [HelpController::class, 'showHelpDoctor'])->name('help-show-doctor');
    Route::post('/{help}/doctor-activate', [HelpController::class, 'activateHelp'])->name('help-activate-doctor');
});

require __DIR__ . '/auth.php';
