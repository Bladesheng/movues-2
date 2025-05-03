<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { IFilters, IGenre, IMedia, IPagination } from '@/types/types.ts';
import MediaGrid from '@/components/MediaGrid.vue';

defineOptions({ inheritAttrs: false });

const { movies, genres, filters } = defineProps<{
	movies: IPagination<IMedia[]>;
	genres: IGenre[];
	filters: IFilters;
}>();

function refreshFilters(value: any) {
	router.get(
		route('movies.index'),
		{
			...value,
		},
		{
			only: ['movies', 'filters'],
			preserveState: true,
			preserveScroll: true,
		}
	);
}
</script>

<template>
	<Head title="Movies" />

	<MediaGrid
		:pagination="movies"
		:genres
		:filters
		@refreshFilters="refreshFilters"
		mediaShowRoute="movies.show"
		mediaName="movie"
	/>
</template>

<style scoped></style>
