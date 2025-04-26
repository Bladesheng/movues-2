<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class MovieController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		//	$genreId = 80;
		//	$movies = Movie::with('movieGenres')
		//		->whereHas('movieGenres', function ($query) use ($genreId) {
		//			$query->where('movie_genres.id', $genreId);
		//		})
		//		->get();

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
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Movie $movie)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Movie $movie)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Movie $movie)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Movie $movie)
	{
		//
	}
}
