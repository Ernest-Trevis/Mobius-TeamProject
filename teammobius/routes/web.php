<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect('/signin');
});

Route::get('/signup', [AuthController::class, 'showSignUp'])->name('signup.form');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');

Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin.form');
Route::post('/signin', [AuthController::class, 'login'])->name('signin.submit');

Route::get('/dashboard', function () {
    // simple protected placeholder, you can replace with controller
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
