<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Tmdb
{
	/**
	 * @param string $mediaType 'movie' or 'tv'
	 * @param string $id
	 * @return array|mixed
	 * @throws ConnectionException
	 * @throws RequestException
	 */
	public static function getDetails(string $mediaType, string $id)
	{
		$cacheKey = "tmdb_details_{$mediaType}_{$id}";
		$details = Cache::get($cacheKey);
		if ($details) {
			return $details;
		}

		$details = Http::withToken(env('TMDB_API_KEY'))
			->get("https://api.themoviedb.org/3/{$mediaType}/{$id}", [
				'append_to_response' => 'videos,credits,keywords,images,external_ids',
				'language' => 'null,en',
			])
			->throw()
			->json();

		Cache::put($cacheKey, $details, now()->addDay());

		return $details;
	}

	public static function getMovies(int $page)
	{
		return Http::withToken(env('TMDB_API_KEY'))
			->get('https://api.themoviedb.org/3/discover/movie', [
				'primary_release_date.gte' => Carbon::now()->subDays(90)->toDateString(),
				'sort_by' => 'primary_release_date.asc',
				'language' => 'en-US',
				'with_original_language' => 'en',
				'page' => $page,
			])
			->throw()
			->json();
	}
}
