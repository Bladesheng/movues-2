<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const { href, active } = defineProps<{
	href: string;
	active: boolean;
}>();
</script>

<template>
	<Link
		:href
		class="btn btn-ghost text-xl"
		:class="{
			'btn-active': active,
		}"
	>
		<slot />
	</Link>
</template>

<style scoped></style>
