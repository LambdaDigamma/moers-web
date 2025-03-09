import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';

export const IndexEvents = ({}) => {
    return (
        <div>
            <Head title="Veranstaltungen" />
            Test
        </div>
    );
};

IndexEvents.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default IndexEvents;
