<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(["controller" => AuthController::class], function() {
    // Get Routes
    Route::get('/login', 'login')->name('login');
    Route::get('/signup', 'signup')->name('signup');
    Route::get('/register', 'register')->name('register');

    // Post Routes
    Route::post('/signup', 'create')->name('member.create');
    Route::post('/register', 'store')->name('trainer.store');
    Route::post('/login', 'authenticate')->name('authenticate');

    // Logout Route
    Route::get('/logout', 'logout')->name('logout');
});