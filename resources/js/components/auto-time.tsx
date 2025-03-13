import { format, toZonedTime } from 'date-fns-tz';
import React from 'react';

interface DateFormatterProps {
    dateString: string;
    formatString?: string;
}

export const AutoDateTime: React.FC<DateFormatterProps> = ({ dateString, formatString = 'yyyy-MM-dd HH:mm:ss' }) => {
    if (!dateString) return <p role="alert">No date provided</p>;

    try {
        const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const zonedDate = toZonedTime(dateString, timeZone);
        const formattedDate = format(zonedDate, formatString, { timeZone });
        return <time dateTime={dateString}>{formattedDate}</time>;
    } catch (error) {
        return <span role="alert">Invalid date</span>;
    }
};
