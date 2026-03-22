import { formatEventDateRange } from '@/lib/date';
import React from 'react';

interface DateRangeProps {
    start: string | null;
    end: string | null;
    showTime?: boolean;
    isMultiDay?: boolean;
}

export const AutoDateRange: React.FC<DateRangeProps> = ({ start, end, showTime = true, isMultiDay }) => {
    const formattedRange = formatEventDateRange(start, end, { showTime, isMultiDay });

    if (!start || formattedRange == null) {
        return <span role="alert">Ungueltiger Zeitraum</span>;
    }

    return (
        <span>
            <time dateTime={start}>{formattedRange}</time>
        </span>
    );
};
