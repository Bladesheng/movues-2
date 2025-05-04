<script setup lang="ts">
import { useDark } from '@vueuse/core';

const isDark = useDark({
	selector: 'html',
	attribute: 'data-theme',
	valueDark: 'dark',
	valueLight: 'light',
});
</script>

<template>
	<label class="swap swap-rotate text-2xl">
		<input v-model="isDark" type="checkbox" />

		<span class="swap-on icon-[heroicons--moon]"></span>
		<span class="swap-off icon-[heroicons--sun]"></span>
	</label>
</template>

<style scoped></style>
