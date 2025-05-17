<script setup lang="ts">
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import { Deferred, Head } from '@inertiajs/vue3';
import CsfdDetails from '@/components/CsfdDetails.vue';
import { computed } from 'vue';
import TmdbDetails from '@/components/TmdbDetails.vue';
import { AppendToResponse, MovieDetails } from 'tmdb-ts';
import { IImdbDetails } from '@/types/types.ts';

defineOptions({ inheritAttrs: false });

const { tmdb, csfd, imdb } = defineProps<{
	tmdb: AppendToResponse<
		MovieDetails,
		('videos' | 'credits' | 'keywords' | 'images' | 'external_ids')[],
		'movie'
	>;
	csfd?: ICsfdMovie | null;
	imdb?: IImdbDetails | null;
}>();

const runtimeText = computed(() => {
	const hours = Math.floor(tmdb.runtime / 60);
	const minutes = Math.floor(tmdb.runtime % 60);
	return `${hours} h ${minutes} min`;
});
</script>

<template>
	<Head :title="tmdb.title" />

	<TmdbDetails
		:cast="tmdb.credits.cast.slice(0, 10)"
		:createdBy="tmdb.credits.crew[0]"
		:genres="tmdb.genres"
		:images="tmdb.images"
		:imdbId="tmdb.external_ids.imdb_id"
		:keywords="tmdb.keywords.keywords"
		:name="tmdb.title"
		:overview="tmdb.overview"
		:posterPath="tmdb.poster_path"
		:voteAverage="tmdb.vote_average"
		:voteCount="tmdb.vote_count"
		:releaseDate="new Date(tmdb.release_date)"
		:runtimeText="runtimeText"
		:tagline="tmdb.tagline"
		:tmdbLink="`https://www.themoviedb.org/movie/${tmdb.id}`"
		:videos="tmdb.videos.results.filter((video) => video.site === 'YouTube')"
		:imdbDetails="imdb"
	>
		<template #csfdCard>
			<Deferred data="csfd">
				<template #fallback>
					<div class="skeleton h-[285px]"></div>
				</template>

				<div v-if="csfd">
					<CsfdDetails :movie="csfd" />
				</div>
			</Deferred>
		</template>
	</TmdbDetails>

	<div></div>
</template>

<style scoped></style>
