<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import PosterCard from '@/components/PosterCard.vue';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';
import { debounce } from 'throttle-debounce';
import SliderWithInput from '@/components/SliderWithInput.vue';
import Card from '@/components/Card.vue';
import SectionHeading from '@/components/SectionHeading.vue';
import Pagination from '@/components/Pagination.vue';
import { IPagination } from '@/types/types.ts';

defineOptions({ inheritAttrs: false });

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
	movies: IPagination<IMovie[]>;

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

const refreshFilters = debounce(200, (value: any) => {
	router.get(
		route('movies.index'),
		{
			...value,
		},
		{
			only: ['movies'],
			preserveState: true,
			preserveScroll: true,
		}
	);
});

watch(filter, refreshFilters, { deep: true });
</script>

<template>
	<Head title="Movies" />

	<div class="flex gap-4">
		<Card class="self-start" bodyClass="gap-6">
			<template #title>
				<SectionHeading>Filters</SectionHeading>
			</template>

			<section class="flex min-w-64 flex-col gap-4">
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

				<SliderWithInput
					v-model="filter.popularity"
					id="popularity"
					label="Minimum popularity"
					:max="200"
					step="5"
				/>

				<SliderWithInput v-model="filter.age" id="age" label="Max. movie age (days)" :max="90" />

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
		</Card>

		<section class="flex grow flex-col gap-6">
			<div class="grid gap-4">
				<Link
					v-for="movie in movies.data"
					:key="movie.id"
					:href="route('movies.show', movie.id)"
					class="visited:text-gray-400 dark:visited:text-gray-600"
				>
					<PosterCard
						:name="movie.name"
						:releaseDate="new Date(movie.release_date)"
						:posterPath="movie.poster_path"
						:popularity="movie.popularity"
						:voteAverage="movie.vote_average"
						:voteCount="movie.vote_count"
					/>
				</Link>
			</div>

			<Pagination :pagination="movies" class="self-center" />
		</section>
	</div>
</template>

<style scoped>
.grid {
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>
