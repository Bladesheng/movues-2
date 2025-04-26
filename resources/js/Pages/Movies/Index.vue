<script setup lang="ts">
import PosterCard from '@/components/PosterCard.vue';

const { movies } = defineProps<{
	movies: {
		id: number;
		name: string;
		poster_path: string;
		popularity: number;
		vote_average: number;
		vote_count: number;
		release_date: string;
		created_at: string;
		updated_at: string;
	}[];
}>();
</script>

<template>
	<h1>Movies</h1>

	<div class="grid gap-4">
		<div v-for="movie in movies" :key="movie.id">
			<PosterCard
				:name="movie.name"
				:releaseDate="new Date(movie.release_date)"
				:posterPath="movie.poster_path"
				:popularity="movie.popularity"
				:voteAverage="movie.vote_average"
				:voteCount="movie.vote_count"
			/>
		</div>
	</div>
</template>

<style scoped>
.grid {
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>
