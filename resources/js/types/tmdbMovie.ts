export type ITmdbMovie = {
	adult: boolean;
	backdrop_path: string;
	belongs_to_collection: null;
	budget: number;
	credits: {
		cast: {
			adult: boolean;
			cast_id: number;
			character: string;
			credit_id: string;
			gender: number;
			id: number;
			known_for_department: string;
			name: string;
			order: number;
			original_name: string;
			popularity: number;
			profile_path: string;
		}[];
		crew: {
			adult: boolean;
			gender: number;
			id: number;
			known_for_department: string;
			name: string;
			original_name: string;
			popularity: number;
			profile_path: string | null;
			credit_id: string;
			department: string;
			job: string;
		}[];
	};
	external_ids: {
		imdb_id: string | null;
		wikidata_id: string | null;
		facebook_id: string | null;
		instagram_id: string | null;
		twitter_id: string | null;
	};
	genres: {
		id: number;
		name: string;
	}[];
	homepage: string;
	id: number;
	images: {
		backdrops: IImage[];
		logos: IImage[];
		posters: IImage[];
	};
	imdb_id: string | null;
	keywords: {
		keywords: {
			id: number;
			name: string;
		}[];
	};
	origin_country: string[];
	original_language: string;
	original_title: string;
	overview: string;
	popularity: number;
	poster_path: string | null;
	production_companies: {
		id: number;
		logo_path: string | null;
		name: string;
		origin_country: string;
	}[];
	production_countries: {
		iso_3166_1: string;
		name: string;
	}[];
	release_date: string;
	revenue: number;
	runtime: number;
	spoken_languages: {
		english_name: string;
		iso_639_1: string;
		name: string;
	}[];
	status: string;
	tagline: string;
	title: string;
	video: boolean;
	videos: {
		results: {
			iso_639_1: string;
			iso_3166_1: string;
			name: string;
			key: string;
			site: string;
			size: number;
			type: string;
			official: boolean;
			published_at: string;
			id: string;
		}[];
	};
	vote_average: number;
	vote_count: number;
};

export type IImage = {
	aspect_ratio: number;
	height: number;
	iso_639_1: string | null;
	file_path: string;
	vote_average: number;
	vote_count: number;
	width: number;
};
