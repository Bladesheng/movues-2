<script setup lang="ts">
const { href, rating, count } = defineProps<{
	href: string;
	rating?: string | number | null;
	count?: string | number | null;
}>();
</script>

<template>
	<div class="grid grid-cols-3 items-center justify-items-center gap-4 rounded text-nowrap">
		<a :href target="_blank">
			<slot />
		</a>

		<strong class="text-4xl">
			<template v-if="rating">{{ rating }}%</template>
		</strong>

		<span class="text-xl">
			<template v-if="count">({{ count }})</template>
		</span>
	</div>
</template>

<style scoped></style>
