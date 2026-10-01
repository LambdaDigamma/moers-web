const startOfDay = (date: Date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());

export const dayDifference = (value: string | Date, reference: Date = new Date()) => {
    const date = typeof value === 'string' ? new Date(value) : value;

    return Math.round((startOfDay(date).getTime() - startOfDay(reference).getTime()) / 86_400_000);
};

export const formatDate = (value: string | null, options: Intl.DateTimeFormatOptions) => {
    if (!value) {
        return null;
    }

    return new Intl.DateTimeFormat('de-DE', options).format(new Date(value));
};

export const formatRelativeDay = (value: string) => {
    const difference = dayDifference(value);

    if (difference === 0) {
        return 'Heute';
    }

    if (difference === 1) {
        return 'Morgen';
    }

    return formatShortDate(value);
};

const monthAbbreviations = ['Jan.', 'Feb.', 'März', 'Apr.', 'Mai', 'Juni', 'Juli', 'Aug.', 'Sep.', 'Okt.', 'Nov.', 'Dez.'];

export const formatDayMonth = (value: string) => {
    const date = new Date(value);

    return `${date.getDate()}. ${monthAbbreviations[date.getMonth()]}`;
};

const weekdayShort = (value: string) => formatDate(value, { weekday: 'short' })?.replace('.', '') ?? '';

export const formatShortDate = (value: string) => `${weekdayShort(value)}, ${formatDayMonth(value)}`;

export const formatDayChipLabel = (value: string) => `${weekdayShort(value)} ${formatDate(value, { day: 'numeric' })}.`;

export const formatWeekdayAbbreviation = (value: string) => weekdayShort(value).toUpperCase();

export const formatTime = (value: string) => formatDate(value, { hour: '2-digit', minute: '2-digit' }) ?? '';

export const formatPublishedAt = (value: string) => {
    const difference = dayDifference(value);

    if (difference === 0) {
        return `Heute, ${formatTime(value)}`;
    }

    if (difference === -1) {
        return 'Gestern';
    }

    return formatDayMonth(value);
};
