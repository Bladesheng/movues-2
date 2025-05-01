<script setup lang="ts">
import SectionHeading from '@/components/SectionHeading.vue';
import { Images } from 'tmdb-ts';
import Card from '@/components/Card.vue';
import { computed } from 'vue';

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
</script>

<template>
	<Card titleClass="justify-between" bodyClass="gap-6">
		<template #title>
			<div class="flex items-center gap-2">
				<SectionHeading>Images</SectionHeading>
				<small class="text-gray-400">({{ imagesCount }})</small>
			</div>

			<button class="btn btn-outline btn-secondary" @click="$emit('clickMore')">More</button>
		</template>

		<div class="flex flex-col items-start gap-4">
			<img
				v-for="img in images.backdrops.slice(0, 3)"
				:src="`https://image.tmdb.org/t/p/w1280${img.file_path}`"
				alt=""
				loading="lazy"
				class="overflow-hidden rounded"
			/>
		</div>
	</Card>
</template>

<style scoped></style>
