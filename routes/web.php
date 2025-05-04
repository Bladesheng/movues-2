<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvSeriesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Home');
})->name('home');

Route::resource('movies', MovieController::class);

Route::resource('tv', TvSeriesController::class);
