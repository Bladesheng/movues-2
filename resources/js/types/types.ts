export type VueClass = string | Record<string, boolean> | VueClass[];

export type IPagination<T = any[]> = {
	current_page: number;
	data: T;
	first_page_url: string;
	from: number;
	last_page: number;
	last_page_url: string;
	links: {
		url: string | null;
		label: string;
		active: boolean;
	}[];
	next_page_url: string | null;
	path: string;
	per_page: number;
	prev_page_url: string | null;
	to: number;
	total: number;
};

export type IMedia = {
	id: number;
	name: string;
	poster_path: string;
	popularity: number;
	vote_average: number;
	vote_count: number;
	release_date: string;
	created_at: string;
	updated_at: string;
};

export type IGenre = {
	id: number;
	name: string;
	created_at: string;
	updated_at: string;
};

export type IFilters = {
	popularity: number;
	age: number;
	order: string;
	genres: string[];
};
