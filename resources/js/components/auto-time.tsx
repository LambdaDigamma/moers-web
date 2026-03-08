import { formatDateTime } from '@/lib/date';
import React from 'react';

interface DateFormatterProps {
    dateString: string;
    options?: Intl.DateTimeFormatOptions;
}

export const AutoDateTime: React.FC<DateFormatterProps> = ({ dateString, options = { dateStyle: 'medium', timeStyle: 'short' } }) => {
    if (!dateString) {
        return <p role="alert">Kein Datum vorhanden</p>;
    }

    const formattedDate = formatDateTime(dateString, options);

    if (formattedDate == null) {
        return <span role="alert">Ungueltiges Datum</span>;
    }

    return <time dateTime={dateString}>{formattedDate}</time>;
};
