<script setup lang="ts">
import SectionHeading from '@/components/SectionHeading.vue';
import { Image, Images } from 'tmdb-ts';
import Card from '@/components/Card.vue';
import { computed } from 'vue';
import { srcset } from '@/utils/imagesSizes.ts';

const { images } = defineProps<{
	images: Omit<Images, 'id'>;
}>();

defineEmits(['clickMore']);

const imagesCount = computed(() =>
	Object.values(images).reduce((total, imagesGroup) => {
		if (imagesGroup.length) {
			return total + imagesGroup.length;
		}
		return total;
	}, 0)
);

const availableImages = computed<Image[]>(() => {
	let availableImages = images.backdrops;

	if (availableImages.length === 0) {
		availableImages = images.posters;
	}

	if (availableImages.length === 0) {
		availableImages = images.logos;
	}

	return availableImages.slice(0, 3);
});
</script>

<template>
	<Card v-if="imagesCount" titleClass="justify-between" bodyClass="gap-6">
		<template #title>
			<div class="flex items-center gap-2">
				<SectionHeading>Images</SectionHeading>
				<small class="text-gray-400">({{ imagesCount }})</small>
			</div>

			<button class="btn btn-outline btn-secondary" @click="$emit('clickMore')">More</button>
		</template>

		<div class="flex flex-col items-start gap-4">
			<img
				v-for="image in availableImages"
				:key="image.file_path"
				loading="lazy"
				:src="`https://image.tmdb.org/t/p/w1280${image.file_path}`"
				width="1280"
				:height="1280 / image.aspect_ratio"
				alt=""
				class="overflow-hidden rounded"
				:srcset="srcset.backdrops(image.file_path)"
				sizes="
				    (max-width: 380px) 300px,
				    (max-width: 1160px) 780px,
				    1280px
                "
			/>
		</div>
	</Card>
</template>

<style scoped></style>
