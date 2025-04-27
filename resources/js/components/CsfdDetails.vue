<script setup lang="ts">
import { ref } from 'vue';
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import CsfdIcon from '@/components/CsfdIcon.vue';

const { movie } = defineProps<{
	movie: ICsfdMovie;
}>();

const MAX_LENGTH = 150;

const isExpanded = ref(false);
</script>

<template>
	<section class="card card-border bg-base-200 csfdDetails w-96" :class="{ dark: true }">
		<div class="card-body">
			<strong class="card-title">CSFD Details</strong>

			<div
				class="grid grid-cols-3 items-center justify-items-center gap-4 rounded text-nowrap text-white"
				:class="{
					colorGood: movie.colorRating === 'good',
					colorAverage: movie.colorRating === 'average',
					colorBad: movie.colorRating === 'bad',
					colorUnknown: movie.colorRating === 'unknown',
				}"
			>
				<a :href="movie.url" target="_blank">
					<CsfdIcon class="h-16 w-16" src="/csfdLogo.svg" alt="csfd logo" />
				</a>

				<strong class="text-4xl" title="CSFD rating">{{ movie.rating ?? '? ' }}%</strong>

				<span v-if="movie.rating !== null" class="mr-2 text-xl" title="count of CSFD ratings">
					({{ movie.ratingCount }})
				</span>
			</div>

			<strong class="mt-2 block text-lg">
				{{ movie.title }}
			</strong>

			<p v-if="movie.descriptions[0] !== undefined">
				{{ movie.descriptions[0].substring(0, isExpanded ? Infinity : MAX_LENGTH) }}
				<template v-if="!isExpanded && movie.descriptions[0].length > MAX_LENGTH">
					<span>... </span>
					<button @click="isExpanded = true">(<span class="textGood">více</span>)</button>
				</template>
			</p>
		</div>
	</section>
</template>

<style scoped>
.csfdDetails {
	--csfd-good: #ba0305;
	--csfd-average: #658db4;
	--csfd-bad: #535353;
	--csfd-unknown: #a4a4a4;
}

.csfdDetails.dark {
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
