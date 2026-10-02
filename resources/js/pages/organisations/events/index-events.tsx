import { DefaultContainer } from '@/components/default-container';
import { SeoHead } from '@/components/seo-head';
import { Button } from '@/components/ui/button-catalyst';
import { default as AppLayout } from '@/layouts/app-layout';
import { EventRow } from '@/pages/events/event-row';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import React from 'react';
import Event = Modules.Events.Data.Event;
import Organisation = Modules.Management.Data.Organisation;

export const IndexEvents = ({
    organisation,
    events,
    canCreateEvents,
}: {
    organisation: Organisation;
    events: Paginator<Event>;
    canCreateEvents?: boolean;
}) => {
    return (
        <>
            <SeoHead
                title={`Veranstaltungen von ${organisation.name}`}
                description={`Kommende Veranstaltungen von ${organisation.name} in Moers und Umgebung.`}
            />
            <DefaultContainer className="py-12 md:py-16">
                <div className="border-border flex w-full flex-wrap items-end justify-between gap-4 border-b pb-6">
                    <div>
                        <h2 className="font-display tracking-heading text-2xl font-semibold">Veranstaltungen</h2>
                    </div>
                    {canCreateEvents && (
                        <div className="flex gap-4">
                            <Button>Neue erstellen</Button>
                        </div>
                    )}
                </div>

                <div className="mt-8">
                    <div className="divide-border border-border bg-card divide-y overflow-hidden rounded-xl border">
                        {events.data.length > 0 ? (
                            events.data.map((event) => (
                                <EventRow
                                    key={event.id}
                                    event={event}
                                />
                            ))
                        ) : (
                            <div className="py-12 text-center">
                                <p className="text-muted-foreground text-sm">Keine Veranstaltungen gefunden.</p>
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
