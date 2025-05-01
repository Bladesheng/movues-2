<script setup lang="ts">
import { ref } from 'vue';
import YoutubeIframe from '@/components/YoutubeIframe.vue';
import Resizer from '@/components/Resizer.vue';
import YoutubePlay from '@/components/svg/YoutubePlay.vue';

const { videoKey, name } = defineProps<{
	videoKey: string;
	name?: string;
}>();

const isOpen = ref(false);
</script>

<template>
	<template v-if="!isOpen">
		<button class="relative cursor-pointer" @click="isOpen = true">
			<img
				loading="lazy"
				:src="`https://img.youtube.com/vi_webp/${videoKey}/maxresdefault.webp`"
				width="1280"
				height="720"
				alt="video thumbnail"
				class="w-full cursor-pointer rounded"
			/>

			<span class="flex h-9 items-center justify-center">
				{{ name }}
			</span>

			<span class="absolute inset-0 flex items-center justify-center hover:brightness-75">
				<YoutubePlay class="h-12" />
			</span>
		</button>
	</template>
	<template v-else>
		<Resizer>
			<YoutubeIframe :videoKey />
		</Resizer>
	</template>
</template>

<style scoped></style>
