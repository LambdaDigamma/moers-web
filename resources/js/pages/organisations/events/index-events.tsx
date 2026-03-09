import { Button } from '@/components/ui/button-catalyst';
import { Heading } from '@/components/ui/heading';
import { default as AppLayout } from '@/layouts/app-layout';
import { EventRow } from '@/pages/events/event-row';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const IndexEvents = ({ events, canCreateEvents }: { events: Paginator<Event>; canCreateEvents?: boolean }) => {
    return (
        <>
            <Head title="Veranstaltungen" />
            <div className="mt-8">
                <div className="flex w-full flex-wrap items-end justify-between gap-4 border-b border-zinc-950/10 pb-6 dark:border-white/10">
                    <div className="px-4 sm:px-6 lg:px-8">
                        <Heading>Veranstaltungen</Heading>
                    </div>
                    {canCreateEvents && (
                        <div className="flex gap-4 px-4 sm:px-6 lg:px-8">
                            <Button>Neue erstellen</Button>
                        </div>
                    )}
                </div>

                <div className="mt-6 px-4 sm:px-6 lg:px-8">
                    <div className="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-white/5 dark:bg-zinc-900">
                        <ul className="divide-y divide-zinc-200 dark:divide-white/10">
                            {events.data.length > 0 ? (
                                events.data.map((event) => (
                                    <li
                                        key={event.id}
                                        className="px-4 py-4 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                    >
                                        <EventRow event={event} />
                                    </li>
                                ))
                            ) : (
                                <li className="py-12 text-center">
                                    <p className="text-sm text-zinc-500 dark:text-zinc-400">Keine Veranstaltungen gefunden.</p>
                                </li>
                            )}
                        </ul>
                    </div>
                </div>
            </div>
        </>
    );
};

IndexEvents.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default IndexEvents;
