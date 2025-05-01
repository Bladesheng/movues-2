<script setup lang="ts">
import SectionHeading from '@/components/SectionHeading.vue';
import { Cast } from 'tmdb-ts';
import Card from '@/components/Card.vue';

const { actors } = defineProps<{
	actors: Cast[];
}>();
</script>

<template>
	<Card v-if="actors.length > 0" bodyClass="gap-6">
		<template #title>
			<SectionHeading>Cast</SectionHeading>
		</template>

		<ol
			class="flex gap-2 overflow-x-auto"
			:class="{
				dark: true,
			}"
		>
			<template v-for="actor in actors">
				<li
					v-if="actor.profile_path !== null"
					class="max-w-32 flex-shrink-0 overflow-hidden rounded-xl border border-gray-300 sm:max-w-44 dark:border-gray-600"
				>
					<img
						loading="lazy"
						:src="`https://image.tmdb.org/t/p/w185${actor.profile_path}`"
						width="185"
						:height="185 * 1.5"
						:alt="actor.name"
					/>

					<div class="p-2 text-center">
						<div class="font-semibold">
							{{ actor.name }}
						</div>

						<div class="mt-0.5 text-sm">
							{{ actor.character }}
						</div>
					</div>
				</li>
			</template>
		</ol>
	</Card>
</template>

<style scoped>
ol::-webkit-scrollbar {
	height: 10px;
}

ol::-webkit-scrollbar-thumb {
	border-radius: 9999px;
	background: #d1d5db;
}

ol.dark::-webkit-scrollbar-thumb {
	background: #4b5563;
}
</style>
