<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { getDaysLeft, getFullDateFormatted } from '@/utils/date';
import SectionHeading from '@/components/SectionHeading.vue';
import CastList from '@/components/CastList.vue';
import TmdbLogoPrimaryShort from '@/components/svg/TmdbLogoPrimaryShort.vue';
import ImdbLogo from '@/components/svg/ImdbLogo.vue';
import VideosCard from '@/components/VideosCard.vue';
import ImagesCard from '@/components/ImagesCard.vue';
import type { Cast, Crew, Genre, Images, Keyword, Network, Video } from 'tmdb-ts';
import Card from '@/components/Card.vue';
import ImageGallery from '@/components/ImageGallery.vue';
import VideoGallery from '@/components/VideoGallery.vue';
import { srcset } from '@/utils/imagesSizes.ts';
import { locale } from '@/utils/locale.ts';

const {
	cast,
	createdBy,
	genres,
	images,
	imdbId,
	keywords,
	name,
	networks,
	overview,
	posterPath,
	rating,
	releaseDate,
	runtimeText,
	tagline,
	tmdbLink,
	videos,
} = defineProps<{
	cast: Cast[];
	createdBy?: Crew;
	genres: Genre[];
	images: Omit<Images, 'id'>;
	imdbId: string | null;
	keywords: Keyword[];
	name: string;
	networks?: Network[];
	overview: string;
	posterPath: string | null | undefined;
	rating: number;
	releaseDate: Date;
	runtimeText?: string;
	tagline: string;
	tmdbLink: string;
	videos: Video[];
}>();

const activeTab = ref(window.location.hash.replace('#', ''));

const ratingRounded = computed(() => Math.round(rating * 10));

const imagesCount = Object.values(images).reduce((acc, group) => acc + group.length, 0);

watch(activeTab, (activeTab) => {
	if (activeTab === '') {
		window.history.pushState(null, '', window.location.pathname);
	} else {
		window.history.pushState(null, '', `#${activeTab}`);
	}
});
</script>

<template>
	<div class="flex min-w-0 flex-col gap-4 md:flex-row">
		<section class="flex min-w-0 flex-col gap-4">
			<Card bodyClass="@container">
				<div class="grid grid-cols-[auto_auto] gap-4 @2xl:grid-cols-[auto_1fr]">
					<img
						v-if="posterPath"
						:src="`https://image.tmdb.org/t/p/w342${posterPath}`"
						width="400"
						height="600"
						alt="poster"
						class="w-auto self-start overflow-hidden rounded @2xl:row-span-2"
						:srcset="srcset.posters(posterPath)"
						sizes="
						    (max-width: 400px) 92px,
						    (max-width: 500px) 154px,
						    (max-width: 800px) 185px,
						    200px
                        "
					/>

					<div class="flex flex-col gap-2">
						<SectionHeading class="text-4xl">
							{{ name }}
						</SectionHeading>

						<div class="flex flex-wrap gap-2">
							<span v-for="genre in genres" title="Genre" class="badge badge-primary">
								{{ genre.name }}
							</span>
						</div>

						<div title="Release date">
							{{ getFullDateFormatted(releaseDate, locale) }}
							({{ getDaysLeft(releaseDate) }})
						</div>

						<div v-if="runtimeText === undefined" class="skeleton h-6 w-36"></div>
						<div v-else-if="runtimeText.length > 0" class="h-6">
							{{ runtimeText }}
						</div>

						<div v-if="createdBy !== undefined">
							<strong>{{ createdBy.department }}: </strong>
							<span>{{ createdBy.name }}</span>
						</div>
					</div>

					<div class="col-span-2 flex flex-col gap-0.5 @2xl:col-start-2">
						<strong class="block">Overview</strong>
						<em class="block text-gray-500">
							{{ tagline }}
						</em>
						<p class="max-w-[670px]">
							{{ overview }}
						</p>
					</div>
				</div>
			</Card>

			<CastList :actors="cast" />

			<div role="tablist" class="tabs tabs-border">
				<button
					role="tab"
					class="tab"
					:class="{ 'tab-active': activeTab === '' }"
					@click="activeTab = ''"
				>
					Overview
				</button>
				<button
					v-if="videos.length"
					role="tab"
					class="tab"
					@click="activeTab = 'videos'"
					:class="{ 'tab-active': activeTab === 'videos' }"
				>
					Videos ({{ videos.length }})
				</button>
				<button
					v-if="imagesCount"
					role="tab"
					class="tab"
					@click="activeTab = 'images'"
					:class="{ 'tab-active': activeTab === 'images' }"
				>
					Images ({{ imagesCount }})
				</button>
			</div>

			<template v-if="activeTab === ''">
				<VideosCard :videos="videos" @clickMore="activeTab = 'videos'" />
				<ImagesCard :images="images" @clickMore="activeTab = 'images'" />
			</template>
			<template v-else-if="activeTab === 'images'">
				<ImageGallery :images="images" />
			</template>
			<template v-else-if="activeTab === 'videos'">
				<VideoGallery :videos="videos" />
			</template>
		</section>

		<section class="flex shrink-0 flex-col items-stretch gap-4 md:w-1/3 xl:w-1/5">
			<Card bodyClass="gap-8">
				<template #title>
					<SectionHeading>Rating</SectionHeading>
				</template>

				<div class="flex flex-col gap-6">
					<div class="flex items-center gap-4">
						<a :href="tmdbLink" target="_blank" title="tmdb">
							<TmdbLogoPrimaryShort class="h-12" />
						</a>

						<strong class="text-4xl text-nowrap" title="TMDB rating">{{ ratingRounded }}%</strong>
					</div>

					<a
						v-if="imdbId !== null"
						:href="`https://www.imdb.com/title/${imdbId}`"
						target="_blank"
						title="imdb"
					>
						<ImdbLogo class="h-12" />
					</a>

					<slot name="csfdCard" />
				</div>
			</Card>

			<Card v-if="keywords.length" bodyClass="gap-6">
				<template #title>
					<SectionHeading>Keywords</SectionHeading>
				</template>

				<div class="flex flex-wrap gap-2">
					<span v-for="keyword in keywords" class="badge badge-secondary">
						{{ keyword.name }}
					</span>
				</div>
			</Card>

			<Card v-if="networks !== undefined" bodyClass="gap-6">
				<template #title>
					<SectionHeading>
						<span>Network</span>
						<template v-if="networks.length > 1">s</template>
					</SectionHeading>
				</template>

				<div class="flex flex-col items-center gap-2">
					<img
						v-for="network in networks"
						loading="lazy"
						:src="`https://image.tmdb.org/t/p/w200${network.logo_path}`"
						width="200"
						height="100"
						:alt="network.name"
						:title="network.name"
					/>
				</div>
			</Card>
		</section>
	</div>
</template>

<style scoped></style>
