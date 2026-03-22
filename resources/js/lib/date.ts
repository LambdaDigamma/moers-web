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

type EventDateRangeOptions = {
    showTime?: boolean;
    isMultiDay?: boolean;
};

export function formatEventDateRange(
    start: string | Date | null | undefined,
    end: string | Date | null | undefined,
    options: EventDateRangeOptions = {},
): string | null {
    const startDate = toDate(start);
    const endDate = toDate(end);
    const { showTime = true, isMultiDay } = options;

    if (startDate == null) {
        return null;
    }

    const isEffectivelySameDay = (s: Date, e: Date) => {
        if (isMultiDay !== undefined) {
            return !isMultiDay;
        }

        if (s.getFullYear() === e.getFullYear() && s.getMonth() === e.getMonth() && s.getDate() === e.getDate()) {
            return true;
        }

        const nextDayAt6am = new Date(s);
        nextDayAt6am.setDate(s.getDate() + 1);
        nextDayAt6am.setHours(6, 0, 0, 0);

        return e <= nextDayAt6am;
    };

    if (!showTime) {
        const dateFormatter = new Intl.DateTimeFormat(undefined, {
            dateStyle: 'medium',
        });

        if (endDate == null) {
            return dateFormatter.format(startDate);
        }

        if (isEffectivelySameDay(startDate, endDate)) {
            return dateFormatter.format(startDate);
        }

        return `${dateFormatter.format(startDate)} - ${dateFormatter.format(endDate)}`;
    }

    const dateTimeFormatter = new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
    const dateFormatter = new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
    });
    const timeFormatter = new Intl.DateTimeFormat(undefined, {
        timeStyle: 'short',
    });

    if (endDate == null) {
        return dateTimeFormatter.format(startDate);
    }

    if (isEffectivelySameDay(startDate, endDate)) {
        const datePart = dateFormatter.format(startDate);
        const startTimePart = timeFormatter.format(startDate);
        const endTimePart = timeFormatter.format(endDate);

        return `${datePart}, ${startTimePart} - ${endTimePart}`;
    }

    return `${dateTimeFormatter.format(startDate)} - ${dateTimeFormatter.format(endDate)}`;
}
