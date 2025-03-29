import { AutoDateRange } from '@/components/auto-timerange';
import { Link } from '@/components/ui/link';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const EventRow: React.FC<{ event: Event }> = ({ event }) => {
    return (
        <div className="relative">
            <p className="text-sm font-medium">{event.name}</p>
            <p className="text-sm text-gray-500 dark:text-gray-400">
                {/*<AutoDateTime*/}
                {/*    dateString={event.start_date}*/}
                {/*    formatString=""*/}
                {/*/>*/}
                <AutoDateRange
                    start={event.startDate}
                    end={event.endDate}
                />
            </p>
            <Link
                href={route('events.show', [event.id])}
                className="absolute inset-0"
            >
                <span className="sr-only">Details</span>
            </Link>
        </div>
    );
};
