import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { Heading } from '@/components/ui/heading';
import AppLayout from '@/layouts/app-layout';
import { EventRow } from '@/pages/events/event-row';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';
import Event = Modules.Events.Data.Event;

const EventsIndex = ({ events }: { events: Paginator<Event> }) => {
    return (
        <>
            <Head title="Veranstaltungen"></Head>
            <DefaultContainer>
                <div className="mt-8">
                    <Heading>Veranstaltungen</Heading>
                    <ul className="mt-4 flex flex-col divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow">
                        {events.data.map((event) => (
                            <li
                                key={event.id}
                                className="relative px-4 py-2.5"
                            >
                                <EventRow event={event} />
                            </li>
                        ))}
                    </ul>
                </div>

                <div className="mt-6">
                    <DefaultPagination paginator={events}></DefaultPagination>
                </div>
            </DefaultContainer>
        </>
    );
};

EventsIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default EventsIndex;
