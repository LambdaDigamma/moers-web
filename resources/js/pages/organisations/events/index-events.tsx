import { DefaultContainer } from '@/components/default-container';
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
            <DefaultContainer className="py-8">
                <div className="flex w-full flex-wrap items-end justify-between gap-4 border-b border-zinc-950/10 pb-6 dark:border-white/10">
                    <div>
                        <Heading>Veranstaltungen</Heading>
                    </div>
                    {canCreateEvents && (
                        <div className="flex gap-4">
                            <Button>Neue erstellen</Button>
                        </div>
                    )}
                </div>

                <div className="mt-8">
                    <div className="space-y-4">
                        {events.data.length > 0 ? (
                            events.data.map((event) => (
                                <EventRow
                                    key={event.id}
                                    event={event}
                                />
                            ))
                        ) : (
                            <div className="py-12 text-center">
                                <p className="text-sm text-zinc-500 dark:text-zinc-400">Keine Veranstaltungen gefunden.</p>
                            </div>
                        )}
                    </div>
                </div>
            </DefaultContainer>
        </>
    );
};

IndexEvents.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default IndexEvents;
