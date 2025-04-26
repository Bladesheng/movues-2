import path from 'node:path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import VueDevTools from 'vite-plugin-vue-devtools';

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.ts'],
			refresh: true,
		}),
		vue(),
		tailwindcss(),
		VueDevTools({
			appendTo: 'app.ts',
			launchEditor: 'phpstorm',
		}),
	],

	resolve: {
		alias: {
			'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
		},
	},
});
