import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button-catalyst';
import { Heading } from '@/components/ui/heading';
import { default as AppLayout } from '@/layouts/app-layout';
import { EventRow } from '@/pages/events/event-row';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const IndexEvents = ({ events }: { events: Paginator<Event> }) => {
    return (
        <>
            <Head title="Veranstaltungen" />
            <div className="mt-12">
                <DefaultContainer>
                    <div className="flex w-full flex-wrap items-end justify-between gap-4 border-b border-zinc-950/10 pb-6 dark:border-white/10">
                        <Heading>Veranstaltungen</Heading>
                        <div className="flex gap-4">
                            {/*<Button outline>Refund</Button>*/}
                            <Button>Neue erstellen</Button>
                        </div>
                    </div>

                    <div className="mt-6 rounded-xl bg-white shadow">
                        <ul className="divide-y divide-gray-200">
                            {events.data.map((event) => {
                                return (
                                    <li className="px-4 py-2.5">
                                        <EventRow event={event} />
                                    </li>
                                );
                            })}
                        </ul>
                    </div>
                </DefaultContainer>
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
