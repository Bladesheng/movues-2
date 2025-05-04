<script setup lang="ts">
import { ICsfdMovie } from '@/types/csfdMovie.ts';
import { Deferred, Head } from '@inertiajs/vue3';
import CsfdDetails from '@/components/CsfdDetails.vue';
import { computed } from 'vue';
import TmdbDetails from '@/components/TmdbDetails.vue';
import { AppendToResponse, TvShowDetails } from 'tmdb-ts';

defineOptions({ inheritAttrs: false });

const { tmdb, csfd } = defineProps<{
	tmdb: AppendToResponse<
		TvShowDetails,
		('videos' | 'credits' | 'keywords' | 'images' | 'external_ids')[],
		'tvShow'
	>;
	csfd?: ICsfdMovie | null;
}>();

const runtimeText = computed(() => {
	if (csfd?.duration === undefined) {
		// csfd is still loading
		return undefined;
	} else if (csfd?.duration === null) {
		// csfd is loaded but duration is unknown
		return '';
	}

	const runtimeTotal = csfd.duration;
	const episodesCount = tmdb.number_of_episodes;

	const episodeRuntime = Math.round(runtimeTotal / episodesCount);

	const hours = Math.floor(runtimeTotal / 60);
	const minutes = Math.floor(runtimeTotal % 60);

	return `${hours} h ${minutes} min (${episodesCount} x ${episodeRuntime} min)`;
});
</script>

<template>
	<Head :title="tmdb.name" />

	<TmdbDetails
		:cast="tmdb.credits.cast.slice(0, 10)"
		:createdBy="tmdb.credits.crew[0]"
		:genres="tmdb.genres"
		:images="tmdb.images"
		:imdbId="tmdb.external_ids.imdb_id"
		:keywords="tmdb.keywords.keywords ?? tmdb.keywords.results"
		:name="tmdb.name"
		:networks="tmdb.networks"
		:overview="tmdb.overview"
		:posterPath="tmdb.poster_path"
		:rating="tmdb.vote_average"
		:releaseDate="new Date(tmdb.first_air_date)"
		:runtimeText="runtimeText"
		:tagline="tmdb.tagline"
		:tmdbLink="`https://www.themoviedb.org/tv/${tmdb.id}`"
		:videos="tmdb.videos.results.filter((video) => video.site === 'YouTube')"
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
