<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import PosterCard from '@/components/PosterCard.vue';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';

const { movies, genres, filters } = defineProps<{
	movies: {
		id: number;
		name: string;
		poster_path: string;
		popularity: number;
		vote_average: number;
		vote_count: number;
		release_date: string;
		created_at: string;
		updated_at: string;
	}[];

	genres: {
		id: number;
		name: string;
		created_at: string;
		updated_at: string;
	}[];

	filters: {
		popularity: string;
		age: string;
	};
}>();

const filter = ref({
	popularity: filters.popularity,
	age: filters.age,
});

// @TODO throttle / debounce
watch(
	filter,
	(value) => {
		console.log(value);
		router.get(
			route('movies.index'),
			{
				...value,
			},
			{
				preserveState: true,
				preserveScroll: true,
				replace: true,
			}
		);
	},
	{ deep: true }
);
</script>

<template>
	<div class="flex gap-4">
		<section class="flex min-w-64 flex-col gap-4">
			<strong>Filters</strong>

			<label class="input">
				<span class="label">Minimal popularity </span>
				<input v-model="filter.popularity" type="number" />
			</label>

			<label class="input">
				<span class="label">Max. movie age (days) </span>
				<input v-model="filter.age" type="number" />
			</label>
		</section>

		<section class="grid grow gap-4">
			<div v-for="movie in movies" :key="movie.id">
				<PosterCard
					:name="movie.name"
					:releaseDate="new Date(movie.release_date)"
					:posterPath="movie.poster_path"
					:popularity="movie.popularity"
					:voteAverage="movie.vote_average"
					:voteCount="movie.vote_count"
				/>
			</div>
		</section>
	</div>
</template>

<style scoped>
.grid {
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>
