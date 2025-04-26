<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
	$page = 1;

	while ($page < 20) {
		//	while (true) {
		$response = Http::withToken(env('TMDB_API_KEY'))->get(
			'https://api.themoviedb.org/3/discover/movie',
			[
				'primary_release_date.gte' => '2025-04-21',
				'sort_by' => 'primary_release_date.asc',
				'language' => 'en-US',
				'with_original_language' => 'en',
				'page' => $page,
			]
		);

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
