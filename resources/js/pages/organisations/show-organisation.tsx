import { DefaultContainer } from '@/components/default-container';
import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';
import ShowOrganisationProps = Modules.Management.Data.ShowOrganisationProps;

const ShowOrganisation = ({ organisation }: ShowOrganisationProps) => {
    return (
        <>
            <Head title="Bearbeiten"></Head>
            <DefaultContainer>
                <h1 className="text-2xl font-semibold">{organisation.name}</h1>
                {JSON.stringify(organisation)}
            </DefaultContainer>
        </>
    );
};

ShowOrganisation.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default ShowOrganisation;
