<script setup lang="ts">
import { Images } from 'tmdb-ts';
import { computed } from 'vue';
import { srcset } from '@/utils/imagesSizes.ts';

const { images } = defineProps<{
	images: Omit<Images, 'id'>;
}>();

const groupsWithImages = computed(() =>
	Object.fromEntries(Object.entries(images).filter(([groupName, group]) => group.length))
);

const sizes = {
	backdrops: '(max-width: 380px) 300px, (max-width: 1160px) 780px, 1280px',
	posters: '(max-width: 420px) 342px, (max-width: 785px) 500px, 780px',
	logos: '(max-width: 380px) 300px, 500px',
};
</script>

<template>
	<div class="tabs tabs-lift">
		<template v-for="([groupName, group], i) in Object.entries(groupsWithImages)" :key="groupName">
			<template v-if="group.length">
				<input
					type="radio"
					class="tab capitalize"
					name="imageGallery"
					:aria-label="`${groupName} (${group.length})`"
					:checked="i === 0"
				/>

				<div class="tab-content border-base-300 p-6">
					<div class="flex flex-col gap-4">
						<img
							v-for="image in group"
							:key="image.file_path"
							loading="lazy"
							:src="`https://image.tmdb.org/t/p/w1280${image.file_path}`"
							width="1280"
							:height="1280 / image.aspect_ratio"
							alt=""
							class="rounded"
							:srcset="srcset[groupName as keyof typeof srcset]?.(image.file_path)"
							:sizes="sizes[groupName as keyof typeof sizes]"
						/>
					</div>
				</div>
			</template>
		</template>
	</div>
</template>

<style scoped></style>
