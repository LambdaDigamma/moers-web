import { formatEventDateRange } from '@/lib/date';
import React from 'react';

interface DateRangeProps {
    start: string | null;
    end: string | null;
}

export const AutoDateRange: React.FC<DateRangeProps> = ({ start, end }) => {
    const formattedRange = formatEventDateRange(start, end);

    if (!start || formattedRange == null) {
        return <span role="alert">Ungueltiger Zeitraum</span>;
    }

    return (
        <span>
            <time dateTime={start}>{formattedRange}</time>
        </span>
    );
};
