<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Services\Csfd;
use App\Services\Tmdb;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
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

		$movies = fn() => Movie::query()
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

		$allGenres = fn() => Genre::where('movie', true)->orderBy('name')->get();

		return Inertia::render('Movies/Index', [
			'movies' => $movies,
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
	public function show(Movie $movie): Response
	{
		$tmdbDetails = Tmdb::getDetails('movie', $movie->id);

		return Inertia::render('Movies/Show', [
			'tmdb' => fn() => $tmdbDetails,

			'csfd' => Inertia::defer(
				fn() => Csfd::getDetails(
					'movie',
					$tmdbDetails['title'],
					Carbon::parse($tmdbDetails['release_date'])->year
				)
			),
		]);
	}
}
