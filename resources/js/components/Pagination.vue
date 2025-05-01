<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { IPagination } from '@/types/types.ts';

const { pagination } = defineProps<{
	pagination: IPagination;
}>();
</script>

<template>
	<div class="join">
		<Component
			:is="link.url ? Link : 'span'"
			v-for="link in pagination.links"
			:href="link.url ?? ''"
			v-html="link.label"
			class="join-item btn"
			:class="{
				'btn-disabled': !link.url,
				'btn-active': link.active,
			}"
		/>
	</div>
</template>

<style scoped></style>
