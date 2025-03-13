import { format, toZonedTime } from 'date-fns-tz';
import React from 'react';

interface DateRangeProps {
    start: string | null;
    end: string | null;
}

export const AutoDateRange: React.FC<DateRangeProps> = ({ start, end }) => {
    if (!start || !end) return <span role="alert">Invalid date range</span>;

    try {
        const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const startDate = toZonedTime(start, timeZone);
        const endDate = toZonedTime(end, timeZone);

        const formattedStart = format(startDate, 'do LLL HH:mm', { timeZone });
        const formattedEnd = format(endDate, 'do LLL HH:mm', { timeZone });

        return (
            <span>
                <time dateTime={start}>{formattedStart}</time> – <time dateTime={end}>{formattedEnd}</time>
            </span>
        );
    } catch (error) {
        return <span role="alert">Error formatting date range</span>;
    }
};
