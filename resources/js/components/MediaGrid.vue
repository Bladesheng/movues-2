<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PosterCard from '@/components/PosterCard.vue';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';
import { debounce } from 'throttle-debounce';
import SliderWithInput from '@/components/SliderWithInput.vue';
import Card from '@/components/Card.vue';
import SectionHeading from '@/components/SectionHeading.vue';
import Pagination from '@/components/Pagination.vue';
import { IFilters, IGenre, IMedia, IPagination } from '@/types/types.ts';

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

				<SliderWithInput
					v-model="filter.age"
					id="age"
					:label="`Max. ${mediaName} age (days)`"
					:max="90"
				/>

				Genres
				<div class="flex flex-col gap-2">
					<div v-for="genre in genres" :key="genre.id" class="flex items-center gap-2">
						<input
							v-model="filter.genres"
							:value="genre.id.toString()"
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
