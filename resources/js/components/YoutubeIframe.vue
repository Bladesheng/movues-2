<script setup lang="ts">
const { videoKey } = defineProps<{
	videoKey: string;
}>();
</script>

<template>
	<iframe
		:src="`https://www.youtube.com/embed/${videoKey}`"
		class="aspect-video w-full rounded"
		title="YouTube video player"
		allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
		referrerpolicy="strict-origin-when-cross-origin"
		allowfullscreen
	></iframe>
</template>

<style scoped></style>
