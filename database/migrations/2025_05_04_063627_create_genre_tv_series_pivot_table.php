<?php

use App\Models\Genre;
use App\Models\TvSeries;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('genre_tv_series', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(TvSeries::class)->constrained('tv_series')->cascadeOnDelete();
			$table->foreignIdFor(Genre::class)->constrained('genres')->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tv_genre_tv_series');
	}
};
