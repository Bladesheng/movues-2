<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\TvSeries;
use App\Services\Csfd;
use App\Services\Imdb;
use App\Services\Tmdb;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class TvSeriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): Response
	{
		$popularity = (int) ($request->input('popularity') ?? 5);
		$age = (int) ($request->input('age') ?? 30);
		$order = $request->input('order') ?? 'release_date';
		$genres = $request->input('genres') ?? [];

		$tvSeries = fn() => TvSeries::query()
			->where('popularity', '>=', $popularity)
			->whereDate('release_date', '>=', Carbon::now()->subDays($age))
			->when(!empty($genres), function ($query) use ($genres) {
				$query->whereHas(
					'genres',
					function ($query) use ($genres) {
						$query->whereIn('genres.id', $genres);
					},
					'=',
					count($genres)
				);
			})
			->orderBy($order, $order === 'release_date' ? 'asc' : 'desc')
			->paginate(65)
			->withQueryString();

		$allGenres = fn() => Genre::where('tv', true)->orderBy('name')->get();

		return Inertia::render('Tv/Index', [
			'tvSeries' => $tvSeries,
			'genres' => $allGenres,
			'filters' => [
				'popularity' => $popularity,
				'age' => $age,
				'order' => $order,
				'genres' => $genres,
			],
		]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(TvSeries $tv): Response
	{
		$tmdbDetails = Tmdb::getDetails('tv', $tv->id);

		return Inertia::render('Tv/Show', [
			'tmdb' => fn() => $tmdbDetails,

			'csfd' => Inertia::defer(
				fn() => Csfd::getDetails(
					'tv',
					$tmdbDetails['name'],
					Carbon::parse($tmdbDetails['first_air_date'])->year
				)
			),

			'imdb' => Inertia::defer(fn() => Imdb::getDetails($tmdbDetails['external_ids']['imdb_id'])),
		]);
	}
}
