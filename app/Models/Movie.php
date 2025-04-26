<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $poster_path
 * @property int $popularity
 * @property int $vote_average
 * @property int $vote_count
 * @property Carbon $release_date
 *
 * @mixin Eloquent
 */
class Movie extends Model
{
	/** @use HasFactory<\Database\Factories\MovieFactory> */
	use HasFactory;

	public function movieGenres(): BelongsToMany
	{
		return $this->belongsToMany(MovieGenre::class);
	}
}
