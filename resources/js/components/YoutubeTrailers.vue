<script setup lang="ts">
import { computed } from 'vue';
import YoutubeIframe from '@/components/YoutubeIframe.vue';
import SectionHeading from '@/components/SectionHeading.vue';
import { Video } from 'tmdb-ts';
import Card from '@/components/Card.vue';

const { videos } = defineProps<{
	videos: Video[];
}>();

const mostRelevantVideo = computed(() => {
	let mostRelevantVideos = videos.filter((video) => {
		return video.type === 'Trailer';
	});

	// no trailers, try teasers
	if (mostRelevantVideos.length === 0) {
		mostRelevantVideos = videos.filter((video) => {
			return video.type === 'Teaser';
		});
	}

	// no teasers either, try whatever is left
	if (mostRelevantVideos.length === 0) {
		mostRelevantVideos = videos;
	}

	return mostRelevantVideos[0];
});

const videoGroups = computed(() => Object.groupBy(videos, (video) => video.type));

function startDrag(e: MouseEvent) {
	const currentTarget = e.currentTarget as HTMLElement;
	const videoContainer = currentTarget.closest('.relevantVideoContainer') as HTMLElement;
	const iframe = videoContainer.querySelector('iframe') as HTMLIFrameElement;

	const initialWidth = videoContainer.getBoundingClientRect().width;
	const initialHeight = videoContainer.getBoundingClientRect().height;
	const initialX = e.pageX;
	const initialY = e.pageY;
	const aspectRatio = initialWidth / initialHeight;

	// otherwise iframe would capture the mouseup events and you couldn't stop dragging
	iframe.classList.add('pointer-events-none');

	// to keep the width after cancelling max width
	videoContainer.style.width = initialWidth + 'px';
	videoContainer.style.maxWidth = 'none';

	document.addEventListener('mousemove', resize);
	document.addEventListener(
		'mouseup',
		() => {
			document.removeEventListener('mousemove', resize);
			iframe.classList.remove('pointer-events-none');
		},
		{
			once: true,
		}
	);

	function resize(e: MouseEvent) {
		const currentX = e.pageX;
		const currentY = e.pageY;

		const diffX = currentX - initialX;
		const diffY = currentY - initialY;

		// new width based only on movement in X axis
		const xMovementNewWidth = initialWidth + diffX;
		// videoContainer.style.width = xMovementNewWidth + 'px'; // (this is fine, but moving in Y axis wouldn't do anything)

		const yMovementNewHeight = initialHeight + diffY;
		// new width based only on movement in Y axis
		const yMovementNewWidth = yMovementNewHeight * aspectRatio;
		// videoContainer.style.width = yMovementNewWidth + 'px'; // (this is fine, but moving in X axis wouldn't do anything)

		// now we put both new widths together - basically a weighted average
		const newWidth =
			(xMovementNewWidth * initialWidth + yMovementNewWidth * initialHeight) /
			(initialWidth + initialHeight);

		if (newWidth < 200) {
			return;
		}

		videoContainer.style.width = newWidth + 'px';
	}
}
</script>

<template>
	<Card v-if="videos.length > 0" titleClass="justify-between" bodyClass="gap-6">
		<template #title>
			<div class="flex items-center gap-2">
				<SectionHeading>Videos</SectionHeading>
				<small class="text-gray-400">({{ videos.length }})</small>
			</div>

			<button class="btn btn-outline btn-secondary">More</button>
		</template>

		<div class="relevantVideoContainer">
			<YoutubeIframe :videoKey="mostRelevantVideo.key" />

			<div class="flex">
				<button
					@mousedown="startDrag"
					class="btn btn-ghost btn-sm mt-1 ml-auto cursor-nwse-resize"
					title="drag to resize"
				>
					<span class="icon-[heroicons--arrow-down-right]"></span>
				</button>
			</div>
		</div>
	</Card>
</template>

<style scoped>
.relevantVideoContainer {
	will-change: width;
}
</style>
