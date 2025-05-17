<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class Imdb
{
	/**
	 * @param string $id
	 * @return array|mixed
	 * @throws ConnectionException
	 * @throws RequestException
	 */
	public static function getDetails(string $id)
	{
		$cacheKey = "imdb_details_{$id}";
		$details = Cache::get($cacheKey);
		if ($details) {
			return $details;
		}

		$body = Http::withHeaders([
			'User-Agent' =>
				'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36',
		])
			->get("https://www.imdb.com/title/{$id}")
			->throw()
			->body();

		$crawler = new Crawler($body);
		$ratingContainer = $crawler->filter('[data-testid="rating-histogram"]');
		$rating = $ratingContainer->filter('.ipc-rating-star--rating')->text('');
		$voteCount = $ratingContainer->filter('.vote-count')->text('');

		$details = compact('rating', 'voteCount');

		Cache::put($cacheKey, $details, now()->addDay());

		return $details;
	}
}
