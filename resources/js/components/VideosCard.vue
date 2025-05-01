<script setup lang="ts">
import { computed } from 'vue';
import SectionHeading from '@/components/SectionHeading.vue';
import { Video } from 'tmdb-ts';
import Card from '@/components/Card.vue';
import LazyYoutubeVideo from '@/components/LazyYoutubeVideo.vue';

const { videos } = defineProps<{
	videos: Video[];
}>();

defineEmits(['clickMore']);

const mostRelevantVideo = computed(() => {
	let mostRelevantVideos = videos.filter((video) => video.type === 'Trailer');

	// no trailers, try teasers
	if (mostRelevantVideos.length === 0) {
		mostRelevantVideos = videos.filter((video) => video.type === 'Teaser');
	}

	// no teasers either, try whatever is left
	if (mostRelevantVideos.length === 0) {
		mostRelevantVideos = videos;
	}

	return mostRelevantVideos[0];
});
</script>

<template>
	<Card v-if="videos.length > 0" titleClass="justify-between" bodyClass="gap-6">
		<template #title>
			<div class="flex items-center gap-2">
				<SectionHeading>Videos</SectionHeading>
				<small class="text-gray-400">({{ videos.length }})</small>
			</div>

			<button class="btn btn-outline btn-secondary" @click="$emit('clickMore')">More</button>
		</template>

		<LazyYoutubeVideo :videoKey="mostRelevantVideo.key" />
	</Card>
</template>

<style scoped></style>
