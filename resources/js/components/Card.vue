<script setup lang="ts">
import { VueClass } from '@/types/types.ts';

const { bodyClass, titleClass, actionsClass } = defineProps<{
	bodyClass?: VueClass;
	titleClass?: VueClass;
	actionsClass?: VueClass;
}>();
</script>

<template>
	<article class="card bg-base-200 shadow">
		<div :class="['card-body', bodyClass]">
			<header v-if="$slots.title" :class="['card-title', titleClass]">
				<slot name="title" />
			</header>

			<slot />

			<footer v-if="$slots.actions" :class="['card-actions', actionsClass]">
				<slot name="actions" />
			</footer>
		</div>
	</article>
</template>

<style scoped></style>
