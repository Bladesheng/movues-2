<script setup lang="ts">
import { Video } from 'tmdb-ts';
import { computed } from 'vue';
import LazyYoutubeVideo from '@/components/LazyYoutubeVideo.vue';

const { videos } = defineProps<{
	videos: Video[];
}>();

const videoGroups = computed(() => Object.groupBy(videos, (video) => video.type));
</script>

<template>
	<div class="tabs tabs-lift">
		<template v-for="([groupName, group], i) in Object.entries(videoGroups)" :key="groupName">
			<input
				type="radio"
				class="tab capitalize"
				name="videoGallery"
				:aria-label="`${groupName} (${group?.length})`"
				:checked="i === 0"
			/>

			<div class="tab-content border-base-300 p-6">
				<div class="flex flex-col gap-4">
					<template v-for="video in group" :key="video.id">
						<LazyYoutubeVideo :videoKey="video.key" :name="video.name" />
					</template>
				</div>
			</div>
		</template>
	</div>
</template>

<style scoped></style>
