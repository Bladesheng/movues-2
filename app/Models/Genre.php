<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property boolean $movie
 * @property boolean $tv
 *
 * @mixin Eloquent
 */
class Genre extends Model
{
	public function movies(): BelongsToMany
	{
		return $this->belongsToMany(Movie::class);
	}
}
