<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import NavLink from '@/components/NavLink.vue';
import Logo from '@/components/svg/Logo.vue';
import ThemeSwap from '@/components/ThemeSwap.vue';

const page = usePage();
</script>

<template>
	<header class="flex items-center gap-4 p-2 shadow">
		<nav class="navbar grid grid-cols-3">
			<div class="text-primary flex items-center gap-2 text-xl font-bold text-nowrap">
				<Logo class="text-primary h-14 w-14" />
				<span class="hidden sm:inline">MoVues 2</span>
			</div>

			<div class="flex justify-center gap-2">
				<NavLink :href="route('movies.index')" :active="page.component.startsWith('Movies')">
					Movies
				</NavLink>
				<NavLink :href="route('tv.index')" :active="page.component.startsWith('Tv')">
					TV Shows
				</NavLink>
			</div>

			<div class="flex justify-end">
				<ThemeSwap />
			</div>
		</nav>
	</header>

	<main class="m-4">
		<slot />
	</main>
</template>

<style scoped></style>
