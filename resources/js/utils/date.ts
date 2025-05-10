export function getFullDateFormatted(date: Date, locale: string) {
	return date.toLocaleDateString(locale, {
		weekday: 'long',
		day: 'numeric',
		month: 'numeric',
		year: 'numeric',
	});
}

export function getDaysLeft(date: Date) {
	const now = new Date();

	const diff = date.getTime() - now.getTime();

	const daysLeft = Math.floor(diff / (1000 * 60 * 60 * 24)) + 1;

	if (daysLeft <= -2) {
		return `${daysLeft * -1} days ago`;
	} else if (daysLeft === -1) {
		return 'Yesterday';
	} else if (daysLeft === 0) {
		return 'Today';
	} else if (daysLeft === 1) {
		return 'Tomorrow';
	} else {
		return `in ${daysLeft} days`;
	}
}
