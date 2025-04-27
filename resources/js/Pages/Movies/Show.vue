<script setup lang="ts">
import { ITmdbMovie } from '@/types/tmdbMovie.ts';
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import { Deferred } from '@inertiajs/vue3';
import CsfdDetails from '@/components/CsfdDetails.vue';

const { tmdb, csfd } = defineProps<{
	tmdb: ITmdbMovie;
	csfd?: ICsfdMovie;
}>();
</script>

<template>
	<div>
		{{ tmdb.title }}
	</div>

	<Deferred data="csfd">
		<template #fallback>
			<div class="skeleton h-[285px] w-96"></div>
		</template>

		<div v-if="csfd">
			<CsfdDetails :movie="csfd" />
		</div>
	</Deferred>

	<div></div>
</template>

<style scoped></style>
