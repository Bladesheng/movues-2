<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { IFilters, IGenre, IMedia, IPagination } from '@/types/types.ts';
import MediaGrid from '@/components/MediaGrid.vue';

defineOptions({ inheritAttrs: false });

const { tvSeries, genres, filters } = defineProps<{
	tvSeries: IPagination<IMedia[]>;
	genres: IGenre[];
	filters: IFilters;
}>();

function refreshFilters(value: any) {
	router.get(
		route('tv.index'),
		{
			...value,
		},
		{
			only: ['tvSeries', 'filters'],
			preserveState: true,
			preserveScroll: true,
		}
	);
}
</script>

<template>
	<Head title="TV" />

	<MediaGrid
		:pagination="tvSeries"
		:genres
		:filters
		@refreshFilters="refreshFilters"
		mediaShowRoute="tv.show"
		mediaName="show"
	/>
</template>

<style scoped></style>
