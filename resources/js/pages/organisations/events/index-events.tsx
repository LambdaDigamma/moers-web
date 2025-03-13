import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button-catalyst';
import { Heading } from '@/components/ui/heading';
import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';

export const IndexEvents = ({}) => {
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
