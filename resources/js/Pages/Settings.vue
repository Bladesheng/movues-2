<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GithubMark from '@/components/svg/GithubMark.vue';
import TmdbLogoAltShort from '@/components/svg/TmdbLogoAltShort.vue';
import { locale } from '@/utils/locale.ts';

defineOptions({ inheritAttrs: false });

const languages = navigator.languages;
</script>

<template>
	<Head title="Settings" />

	<section>
		<label class="input">
			<span class="label">Date locale</span>
			<input v-model="locale" type="text" placeholder="en" />
		</label>

		<div class="mt-2 flex items-center gap-2">
			<span>Your browser's preferred languages:</span>

			<button
				v-for="language in languages"
				class="btn btn-soft btn-primary btn-sm"
				@click="locale = language"
			>
				{{ language }}
			</button>
		</div>
	</section>

	<footer class="mt-30 flex flex-col items-center gap-4 text-center">
		<small>
			Icons from
			<a class="underline" href="https://www.onlinewebfonts.com/icon" target="_blank">svg icons</a>
			are licensed by CC BY 4.0
		</small>

		<div class="flex flex-col gap-1">
			<small>
				This product uses the
				<a href="https://www.themoviedb.org/" target="_blank" class="underline"> TMDB </a>
				API but is not endorsed or certified by TMDB
			</small>

			<TmdbLogoAltShort class="h-3" />
		</div>

		<a href="https://github.com/Bladesheng/movues-2" target="_blank">
			<GithubMark class="h-5" />
		</a>
	</footer>
</template>

<style scoped></style>
