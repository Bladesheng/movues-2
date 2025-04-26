<script setup lang="ts">
import { route } from 'ziggy-js';
</script>

<template>
	<h1 class="text-3xl font-bold underline">Homepage</h1>

	<span class="icon-[heroicons--home]"></span>

	<button class="btn btn-success">Success</button>

	<div>{{ route('movies.index') }}</div>
</template>

<style scoped></style>
