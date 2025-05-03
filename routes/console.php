<?php

use App\Models\Movie;
use App\Services\Tmdb;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
	$page = 1;

	while ($page < 20) {
		//	while (true) {
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

			$movie->movieGenres()->sync($result['genre_ids']);
			$movie->save();
		}

		Log::info("Processed page {$page}/{$response['total_pages']}");

		if ($page >= $response['total_pages']) {
			break;
		}
		$page++;
	}
})->everyMinute();

Schedule::call(function () {
	$deleted = Movie::query()
		->whereDate('release_date', '<', Carbon::now()->subDays(90))
		->delete();

	Log::info("Deleted {$deleted} movies");
})->everyMinute();
