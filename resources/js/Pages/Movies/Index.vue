<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import PosterCard from '@/components/PosterCard.vue';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';

type IMovie = {
	id: number;
	name: string;
	poster_path: string;
	popularity: number;
	vote_average: number;
	vote_count: number;
	release_date: string;
	created_at: string;
	updated_at: string;
};

const { movies, genres, filters } = defineProps<{
	movies: {
		current_page: number;
		data: IMovie[];
		first_page_url: string;
		from: number;
		last_page: number;
		last_page_url: string;
		links: {
			url: string | null;
			label: string;
			active: boolean;
		}[];
		next_page_url: string | null;
		path: string;
		per_page: number;
		prev_page_url: string | null;
		to: number;
		total: number;
	};

	genres: {
		id: number;
		name: string;
		created_at: string;
		updated_at: string;
	}[];

	filters: {
		popularity: number;
		age: number;
		order: string;
	};
}>();

const filter = ref({
	popularity: filters.popularity,
	age: filters.age,
	order: filters.order,
	genres: [],
});

// @TODO throttle / debounce
watch(
	filter,
	(value) => {
		router.get(
			route('movies.index'),
			{
				...value,
			},
			{
				preserveState: true,
				preserveScroll: true,
			}
		);
	},
	{ deep: true }
);

function loadMore() {
	router.reload({
		only: ['movies'],
		data: {
			page: movies.current_page + 1,
		},
		preserveUrl: true,
	});
}
</script>

<template>
	<div class="flex gap-4">
		<section class="flex min-w-64 flex-col gap-4">
			<strong>Filters</strong>

			Sort by
			<div class="flex items-center gap-2">
				<input
					v-model="filter.order"
					value="release_date"
					id="order-release_date"
					type="radio"
					class="radio"
				/>
				<label for="order-release_date" class="">Release date</label>
			</div>
			<div class="flex items-center gap-2">
				<input
					v-model="filter.order"
					value="popularity"
					id="order-popularity"
					type="radio"
					class="radio"
				/>
				<label for="order-popularity" class="">Popularity</label>
			</div>

			<label class="input">
				<span class="label">Minimal popularity </span>
				<input v-model="filter.popularity" type="number" />
			</label>

			<label class="input">
				<span class="label">Max. movie age (days) </span>
				<input v-model="filter.age" type="number" />
			</label>

			Genres
			<div class="flex flex-col gap-2">
				<div v-for="genre in genres" :key="genre.id" class="flex items-center gap-2">
					<input
						v-model="filter.genres"
						:value="genre.id"
						:id="`genre-${genre.id}`"
						type="checkbox"
						class="checkbox"
					/>

					<label :for="`genre-${genre.id}`">
						{{ genre.name }}
					</label>
				</div>
			</div>
		</section>

		<section class="flex grow flex-col gap-6">
			<div class="grid gap-4">
				<div v-for="movie in movies.data" :key="movie.id">
					<PosterCard
						:name="movie.name"
						:releaseDate="new Date(movie.release_date)"
						:posterPath="movie.poster_path"
						:popularity="movie.popularity"
						:voteAverage="movie.vote_average"
						:voteCount="movie.vote_count"
					/>
				</div>
			</div>

			<button
				v-if="movies.current_page < movies.last_page"
				class="btn self-center"
				@click="loadMore()"
			>
				Load more
			</button>
		</section>
	</div>
</template>

<style scoped>
.grid {
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>
