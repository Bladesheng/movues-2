<script setup lang="ts">
import { ref } from 'vue';
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import CsfdIcon from '@/components/svg/CsfdIcon.vue';
import RatingRow from '@/components/RatingRow.vue';

const { movie } = defineProps<{
	movie: ICsfdMovie;
}>();

const MAX_LENGTH = 150;

const isExpanded = ref(false);
</script>

<template>
	<section class="csfdDetails">
		<div
			class="rounded text-white"
			:class="{
				colorGood: movie.colorRating === 'good',
				colorAverage: movie.colorRating === 'average',
				colorBad: movie.colorRating === 'bad',
				colorUnknown: movie.colorRating === 'unknown',
			}"
		>
			<RatingRow :href="movie.url" :rating="movie.rating ?? '? '" :count="movie.ratingCount">
				<CsfdIcon class="h-16 w-16" src="/csfdLogo.svg" alt="csfd logo" />
			</RatingRow>
		</div>

		<strong class="mt-2 block text-lg">
			{{ movie.title }}
		</strong>

		<p v-if="movie.descriptions[0] !== undefined">
			{{ movie.descriptions[0].substring(0, isExpanded ? Infinity : MAX_LENGTH) }}
			<template v-if="!isExpanded && movie.descriptions[0].length > MAX_LENGTH">
				<span>... </span>
				<button @click="isExpanded = true" class="cursor-pointer">
					(<span class="textGood">více</span>)
				</button>
			</template>
		</p>
	</section>
</template>

<style scoped>
.csfdDetails {
	--csfd-good: #ba0305;
	--csfd-average: #658db4;
	--csfd-bad: #535353;
	--csfd-unknown: #a4a4a4;
}

:global([data-theme='dark'] .csfdDetails) {
	--csfd-good: #971311;
	--csfd-bad: #494949;
	--csfd-unknown: #000;
}

.textGood {
	color: var(--csfd-good);
}

.colorGood {
	background-color: var(--csfd-good);
}

.colorAverage {
	background-color: var(--csfd-average);
}

.colorBad {
	background-color: var(--csfd-bad);
}

.colorUnknown {
	background-color: var(--csfd-unknown);
}
</style>
