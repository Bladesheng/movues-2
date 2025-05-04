<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import NavLink from '@/components/NavLink.vue';

const page = usePage<{
	// auth: { user: { username: string } };
}>();
</script>

<template>
	<header class="flex items-center gap-4 p-2 shadow">
		<div class="text-xl font-bold text-nowrap">MoVues 2</div>

		<nav class="navbar flex gap-4">
			<NavLink :href="route('home')" :active="page.component === 'Home'">Home</NavLink>
			<NavLink :href="route('movies.index')" :active="page.component.startsWith('Movies')">
				Movies
			</NavLink>
			<NavLink :href="route('tv.index')" :active="page.component.startsWith('Tv')">
				TV Shows
			</NavLink>
		</nav>

		<!--			<div>Welcome back {{ page.props.auth.user.username }}</div>-->
	</header>

	<main class="m-4">
		<slot />
	</main>
</template>

<style scoped></style>
