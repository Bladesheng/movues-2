export type ICsfdMovie = {
	id: number;
	title: string;
	year: number;
	duration: number;
	descriptions: string[];
	genres: string[];
	type: string;
	url: string;
	origins: string[];
	colorRating: string;
	rating: number;
	ratingCount: number;
	titlesOther: {
		country: string;
		title: string;
	}[];
	poster: string;
	photo: string;
	trivia: string | null;
	creators: {
		directors: IPerson[];
		writers: IPerson[];
		cinematography: IPerson[];
		music: IPerson[];
		actors: IPerson[];
		basedOn: IPerson[];
		producers: IPerson[];
		filmEditing: IPerson[];
		costumeDesign: IPerson[];
		productionDesign: IPerson[];
	};
	vod: {
		title: string;
		url: string;
	}[];
	tags: string[];
	premieres: {
		country: string | null;
		format: string;
		date: string;
		company: string;
	}[];
	related: any[];
	similar: any[];
};

type IPerson = {
	id: number;
	name: string;
	url: string;
};
