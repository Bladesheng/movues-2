<?php

use App\Models\Movie;
use App\Models\TvSeries;
use App\Services\Tmdb;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
	$page = 1;

	while (true) {
		$response = Tmdb::getMovies($page);

		foreach ($response['results'] as $result) {
			if (!$result['poster_path'] || $result['popularity'] < 5) {
				continue;
			}

			$movie = Movie::findOrNew($result['id']);
			$movie->id = $result['id'];
			$movie->name = $result['title'];
			$movie->poster_path = $result['poster_path'];
			$movie->popularity = round($result['popularity']);
			$movie->vote_average = round($result['vote_average'] * 10);
			$movie->vote_count = $result['vote_count'];
			$movie->release_date = $result['release_date'];
			$movie->save();

			$movie->genres()->sync($result['genre_ids']);
			$movie->save();
		}

		Log::info("[Movies import] Processed page {$page}/{$response['total_pages']}");

		if ($page >= $response['total_pages']) {
			break;
		}
		$page++;
	}
})->daily();

Schedule::call(function () {
	$page = 1;

	while (true) {
		$response = Tmdb::getTvSeries($page);

		foreach ($response['results'] as $result) {
			if (!$result['poster_path'] || $result['popularity'] < 5) {
				continue;
			}

			$tvSeries = TvSeries::findOrNew($result['id']);
			$tvSeries->id = $result['id'];
			$tvSeries->name = $result['name'];
			$tvSeries->poster_path = $result['poster_path'];
			$tvSeries->popularity = round($result['popularity']);
			$tvSeries->vote_average = round($result['vote_average'] * 10);
			$tvSeries->vote_count = $result['vote_count'];
			$tvSeries->release_date = $result['first_air_date'];
			$tvSeries->save();

			$tvSeries->genres()->sync($result['genre_ids']);
			$tvSeries->save();
		}

		Log::info("[TV import] Processed page {$page}/{$response['total_pages']}");

		if ($page >= $response['total_pages']) {
			break;
		}
		$page++;
	}
})->daily();

Schedule::call(function () {
	$deleted = Movie::query()
		->whereDate('release_date', '<', Carbon::now()->subDays(90))
		->delete();

	Log::info("Deleted {$deleted} movies");
})->daily();

Schedule::call(function () {
	$deleted = TvSeries::query()
		->whereDate('release_date', '<', Carbon::now()->subDays(90))
		->delete();

	Log::info("Deleted {$deleted} tv series");
})->daily();
