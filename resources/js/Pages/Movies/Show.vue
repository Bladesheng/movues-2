<script setup lang="ts">
import { ITmdbMovie } from '@/types/tmdbMovie.ts';
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import { Deferred } from '@inertiajs/vue3';

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
			<div>Loading CSFD details...</div>
		</template>

		<div v-if="csfd">
			{{ csfd.title }}
		</div>
	</Deferred>

	<div></div>
</template>

<style scoped></style>
