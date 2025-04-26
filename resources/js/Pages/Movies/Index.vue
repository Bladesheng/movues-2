<script setup>
import { route } from 'ziggy-js';

console.log(route('movies.index'));
</script>

<template>
	<h1 class="text-3xl font-bold underline">Hello world!</h1>

	<span class="icon-[heroicons--home]"></span>

	<button class="btn btn-success">Success</button>

	<div>{{ route('movies.index') }}</div>
</template>

<style scoped></style>
