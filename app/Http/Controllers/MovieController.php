<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieGenre;
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

		$movies = Movie::query()
			->where('popularity', '>=', $popularity)
			->where('release_date', '>=', Carbon::now()->subDays($age)->toDateString())
			->when(!empty($genres), function ($query) use ($genres) {
				$query->whereHas(
					'movieGenres',
					function ($query) use ($genres) {
						$query->whereIn('movie_genres.id', $genres);
					},
					'=',
					count($genres)
				);
			})
			->orderBy($order, $order === 'release_date' ? 'asc' : 'desc')
			->paginate(20)
			->withQueryString();

		return Inertia::render('Movies/Index', [
			'movies' => Inertia::deepMerge($movies),
			'genres' => fn() => MovieGenre::all(),
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
		return Inertia::render('Movies/Show', [
			'tmdb' => Tmdb::getDetails('movie', $movie->id),

			'csfd' => Inertia::defer(
				fn() => Csfd::getDetails(
					'movie',
					Tmdb::getDetails('movie', $movie->id)['title'],
					Carbon::parse(Tmdb::getDetails('movie', $movie->id)['release_date'])->year
				)
			),
		]);
	}
}
