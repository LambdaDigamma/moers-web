function toDate(value: string | Date | null | undefined): Date | null {
    if (value == null) {
        return null;
    }

    const date = value instanceof Date ? value : new Date(value);

    return Number.isNaN(date.getTime()) ? null : date;
}

export function formatMonthYear(value: string | Date | null | undefined): string {
    const date = toDate(value);

    if (date == null) {
        return 'Ohne Termin';
    }

    return new Intl.DateTimeFormat(undefined, {
        month: 'long',
        year: 'numeric',
    }).format(date);
}

export function formatDateTime(value: string | Date | null | undefined, options: Intl.DateTimeFormatOptions = {}): string | null {
    const date = toDate(value);

    if (date == null) {
        return null;
    }

    return new Intl.DateTimeFormat(undefined, options).format(date);
}

export function formatEventDateRange(start: string | Date | null | undefined, end: string | Date | null | undefined): string | null {
    const startDate = toDate(start);
    const endDate = toDate(end);

    if (startDate == null) {
        return null;
    }

    if (endDate == null) {
        return new Intl.DateTimeFormat(undefined, {
            dateStyle: 'medium',
            timeStyle: 'short',
        }).format(startDate);
    }

    const sameDay =
        startDate.getFullYear() === endDate.getFullYear() && startDate.getMonth() === endDate.getMonth() && startDate.getDate() === endDate.getDate();

    if (sameDay) {
        const datePart = new Intl.DateTimeFormat(undefined, {
            dateStyle: 'medium',
        }).format(startDate);
        const startTimePart = new Intl.DateTimeFormat(undefined, {
            timeStyle: 'short',
        }).format(startDate);
        const endTimePart = new Intl.DateTimeFormat(undefined, {
            timeStyle: 'short',
        }).format(endDate);

        return `${datePart}, ${startTimePart} - ${endTimePart}`;
    }

    return `${new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(startDate)} - ${new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(endDate)}`;
}
