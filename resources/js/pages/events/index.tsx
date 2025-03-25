import { AutoDateRange } from '@/components/auto-timerange';
import { DefaultContainer } from '@/components/default-container';
import { Heading } from '@/components/ui/heading';
import { Link } from '@/components/ui/link';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { usePaginator } from 'momentum-paginator';
import { ReactNode } from 'react';
import Event = Modules.Events.Data.Event;

const EventsIndex = ({ events }: { events: Paginator<Event> }) => {
    const { items } = usePaginator(events);

    return (
        <>
            <Head title="Veranstaltungen"></Head>
            <DefaultContainer>
                <div className="mt-8">
                    <Heading>Veranstaltungen</Heading>
                    <ul className="mt-4 flex flex-col gap-6">
                        {events.data.map((event) => (
                            <li
                                key={event.id}
                                className="relative"
                            >
                                <p className="font-medium">{event.name}</p>
                                <p className="text-gray-500 dark:text-gray-400">
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
                                {/*<Link href={route('organisations.edit', [event.slug])}>{event.name}</Link>*/}
                            </li>
                        ))}
                    </ul>
                </div>
            </DefaultContainer>
        </>
    );
};

EventsIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default EventsIndex;
