<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvSeriesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn() => to_route('movies.index'))->name('home');

Route::resource('movies', MovieController::class);

Route::resource('tv', TvSeriesController::class);

Route::get('/settings', fn() => Inertia::render('Settings'))->name('settings');
