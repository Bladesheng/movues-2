const base = 'https://image.tmdb.org/t/p';

function createSizeSet(sizes: number[]) {
	return (path: string) => sizes.map((size) => `${base}/w${size}${path} ${size}w`).join(', ');
}

export const srcset = {
	backdrops: createSizeSet([300, 780, 1280]),
	posters: createSizeSet([92, 154, 185, 342, 500, 780]),
	logos: createSizeSet([45, 92, 154, 185, 300, 500]),
} as const;
