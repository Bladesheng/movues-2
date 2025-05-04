<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	public function run(): void
	{
		$genres = [
			[
				'id' => 28,
				'name' => 'Action',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 10759,
				'name' => 'Action & Adventure',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 12,
				'name' => 'Adventure',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 16,
				'name' => 'Animation',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 35,
				'name' => 'Comedy',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 80,
				'name' => 'Crime',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 99,
				'name' => 'Documentary',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 18,
				'name' => 'Drama',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 10751,
				'name' => 'Family',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 14,
				'name' => 'Fantasy',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 36,
				'name' => 'History',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 27,
				'name' => 'Horror',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 10402,
				'name' => 'Music',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 9648,
				'name' => 'Mystery',
				'movie' => true,
				'tv' => true,
			],
			[
				'id' => 10763,
				'name' => 'News',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10762,
				'name' => 'Kids',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10764,
				'name' => 'Reality',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10749,
				'name' => 'Romance',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 878,
				'name' => 'Science Fiction',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 10765,
				'name' => 'Sci-Fi & Fantasy',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10766,
				'name' => 'Soap',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10767,
				'name' => 'Talk',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 10770,
				'name' => 'TV Movie',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 53,
				'name' => 'Thriller',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 10752,
				'name' => 'War',
				'movie' => true,
				'tv' => false,
			],
			[
				'id' => 10768,
				'name' => 'War & Politics',
				'movie' => false,
				'tv' => true,
			],
			[
				'id' => 37,
				'name' => 'Western',
				'movie' => true,
				'tv' => true,
			],
		];

		foreach ($genres as $genre) {
			Genre::updateOrCreate($genre);
		}
	}
}
