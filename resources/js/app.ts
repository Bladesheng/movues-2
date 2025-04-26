import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Layout from '@/components/Layout.vue';

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

		const page: any = pages[`./Pages/${name}.vue`];
		if (page.default.layout === undefined) {
			page.default.layout = Layout;
		}

		return pages[`./Pages/${name}.vue`] as any;
	},

	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.mount(el);
	},

	title: (title) => `${title} | Inertia Demo`,
});
