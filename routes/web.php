<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Home');
})->name('home');

Route::resource('movies', MovieController::class);
