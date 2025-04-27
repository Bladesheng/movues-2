<script setup lang="ts">
import SectionHeading from '@/components/SectionHeading.vue';
import { Images } from 'tmdb-ts';

const { images } = defineProps<{
	images: Omit<Images, 'id'>;
}>();
</script>

<template>
	<section class="card bg-base-200 shadow">
		<div class="card-body gap-6">
			<div class="card-title flex justify-between">
				<SectionHeading>Images</SectionHeading>
				<button class="btn btn-outline btn-secondary">More</button>
			</div>

			<div class="flex flex-col items-start gap-4">
				<img
					v-for="img in images.backdrops.slice(0, 3)"
					:src="`https://image.tmdb.org/t/p/w1280${img.file_path}`"
					alt=""
					loading="lazy"
					class="overflow-hidden rounded"
				/>
			</div>
		</div>
	</section>
</template>

<style scoped></style>
