<script setup lang="ts">
import SliderWithInput from '@/components/SliderWithInput.vue';
import { IGenre } from '@/types/types.ts';

const filter = defineModel<{
	order: string;
	popularity: number;
	age: number;
	genres: string[];
}>({
	required: true,
});

const { genres, mediaName } = defineProps<{
	genres: IGenre[];
	mediaName: string;
}>();
</script>

<template>
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
</template>

<style scoped></style>
