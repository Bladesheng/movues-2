<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Csfd
{
	/**
	 * @param string $mediaType 'movie' or 'tv'
	 * @param string $name
	 * @param int $year
	 * @return array|mixed
	 * @throws RequestException
	 */
	public static function getDetails(string $mediaType, string $name, int $year)
	{
		$cacheKey = "csfd_details_{$mediaType}_{$name}_{$year}";
		$details = Cache::get($cacheKey);
		if ($details) {
			return $details;
		}

		$response = Http::get("https://csfd.worker.bladesheng.com/detail/{$mediaType}", [
			'name' => $name,
			'year' => $year,
		]);

		if ($response->status() === 404) {
			// try again, this time without the year
			// - movies sometimes get delayed => csfd and tmdb can be out of sync
			$response = Http::get("https://csfd.worker.bladesheng.com/detail/{$mediaType}", [
				'name' => $name,
			])->throw();
		}

		$details = $response->json();

		Cache::put($cacheKey, $details, now()->addDay());

		return $response->json();
	}
}
