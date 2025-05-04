<script setup lang="ts">
import { getDaysLeft, getFullDateFormatted } from '@/utils/date';

const { releaseDate, posterPath, popularity, voteAverage, voteCount, name } = defineProps<{
	releaseDate: Date;
	posterPath: string;
	popularity: number;
	voteAverage: number;
	voteCount: number;
	name: string;
}>();
</script>

<template>
	<div
		class="group relative flex h-full flex-col overflow-hidden rounded border border-gray-300 dark:border-gray-600"
	>
		<div class="relative flex flex-grow overflow-hidden">
			<img
				:src="`https://image.tmdb.org/t/p/w400${posterPath}`"
				alt="show poster"
				class="object-cover duration-200 group-hover:scale-105"
			/>

			<div
				class="bg-opacity-50 absolute bottom-0 left-0 rounded-tr bg-black px-1 py-0.5 text-white"
			>
				<span v-if="voteAverage > 0 && voteCount > 5" class="group-hover:hidden" title="Rating">
					<span class="icon-[heroicons--star-solid] text-yellow-500"></span>

					{{ Math.round(voteAverage * 10) / 10 }}
				</span>

				<span class="hidden group-hover:inline" title="Popularity">
					<span class="icon-[heroicons--arrow-trending-up]"></span>

					<i class="pi pi-chart-line"></i>
					{{ Math.round(popularity) }}
				</span>
			</div>
		</div>

		<div class="bg-opacity-50 absolute top-0 left-0 rounded-br bg-black px-1 py-0.5 text-white">
			<span class="group-hover:hidden">
				{{ getDaysLeft(releaseDate) }}
			</span>

			<span class="hidden text-sm group-hover:inline">
				{{ getFullDateFormatted(releaseDate) }}
			</span>
		</div>

		<div
			class="flex h-12 items-center justify-center text-center text-sm"
			:title="name"
			aria-label="title name"
		>
			{{ name }}
		</div>
	</div>
</template>

<style scoped></style>
