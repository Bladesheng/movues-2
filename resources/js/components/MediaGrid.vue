<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PosterCard from '@/components/PosterCard.vue';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';
import { debounce } from 'throttle-debounce';
import Card from '@/components/Card.vue';
import SectionHeading from '@/components/SectionHeading.vue';
import Pagination from '@/components/Pagination.vue';
import { IFilters, IGenre, IMedia, IPagination } from '@/types/types.ts';
import Filters from '@/components/Filters.vue';

defineOptions({ inheritAttrs: false });

const emit = defineEmits<{
	(e: 'refreshFilters', value: typeof filter.value): void;
}>();

const { pagination, genres, filters, mediaShowRoute, mediaName } = defineProps<{
	pagination: IPagination<IMedia[]>;
	genres: IGenre[];
	filters: IFilters;
	mediaShowRoute: string;
	mediaName: string;
}>();

const filter = ref({
	popularity: filters.popularity,
	age: filters.age,
	order: filters.order,
	genres: filters.genres,
});

const refreshFilters = debounce(200, (value: typeof filter.value) => emit('refreshFilters', value));

watch(filter, refreshFilters, { deep: true });
</script>

<template>
	<div class="flex gap-4">
		<Card class="hidden self-start lg:flex" bodyClass="gap-6">
			<template #title>
				<SectionHeading>Filters</SectionHeading>
			</template>

			<Filters v-model="filter" :genres :mediaName />
		</Card>

		<button
			class="btn btn-lg btn-circle fixed right-2 bottom-2 z-1 lg:hidden"
			onclick="my_modal_1.showModal()"
		>
			<span class="icon-[heroicons--funnel]"></span>
		</button>
		<dialog id="my_modal_1" class="modal">
			<div class="modal-box flex w-full flex-col gap-4 rounded-none">
				<SectionHeading>Filters</SectionHeading>

				<form method="dialog">
					<button class="btn btn-lg btn-ghost absolute top-2 right-2">
						<span class="icon-[heroicons--x-mark]"></span>
					</button>
				</form>

				<Filters v-model="filter" :genres :mediaName />

				<div class="modal-action">
					<form method="dialog">
						<button class="btn">Close</button>
					</form>
				</div>
			</div>
		</dialog>

		<section class="flex grow flex-col gap-6">
			<div class="grid gap-4">
				<Link
					v-for="media in pagination.data"
					:key="media.id"
					:href="route(mediaShowRoute, media.id)"
					class="visited:text-gray-400 dark:visited:text-gray-600"
				>
					<PosterCard
						:name="media.name"
						:releaseDate="new Date(media.release_date)"
						:posterPath="media.poster_path"
						:popularity="media.popularity"
						:voteAverage="media.vote_average"
						:voteCount="media.vote_count"
					/>
				</Link>
			</div>

			<Pagination :pagination="pagination" class="self-center" />
		</section>
	</div>
</template>

<style scoped>
.grid {
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>
