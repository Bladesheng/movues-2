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
				<Logo class="text-primary h-10 w-10 sm:h-14 sm:w-14" />
				<span class="hidden sm:inline">MoVues 2</span>
			</div>

			<div class="flex justify-center gap-1 sm:gap-2">
				<NavLink
					:href="route('movies.index')"
					:active="page.component.startsWith('Movies')"
					class="px-2 sm:px-4"
				>
					Movies
				</NavLink>
				<NavLink
					:href="route('tv.index')"
					:active="page.component.startsWith('Tv')"
					class="px-2 sm:px-4"
				>
					TV Shows
				</NavLink>
			</div>

			<div class="flex justify-end gap-1 sm:gap-2">
				<ThemeSwap />

				<NavLink
					:href="route('settings')"
					:active="page.component.startsWith('Settings')"
					class="btn-circle"
					aria-label="settings"
				>
					<span class="icon-[heroicons--cog-6-tooth]"></span>
				</NavLink>
			</div>
		</nav>
	</header>

	<main class="m-4">
		<slot />
	</main>
</template>

<style scoped></style>
