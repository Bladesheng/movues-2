<script setup lang="ts">
import { Images } from 'tmdb-ts';
import { computed } from 'vue';

const { images } = defineProps<{
	images: Omit<Images, 'id'>;
}>();

const groupsWithImages = computed(() =>
	Object.fromEntries(Object.entries(images).filter(([groupName, group]) => group.length))
);
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
						/>
					</div>
				</div>
			</template>
		</template>
	</div>
</template>

<style scoped></style>
