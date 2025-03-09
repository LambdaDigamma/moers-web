import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';
import EditOrganisationProps = Modules.Management.Data.EditOrganisationProps;

const EditOrganisation = ({ organisation }: EditOrganisationProps) => {
    return (
        <>
            <Head title="Bearbeiten"></Head>
            <div>
                <h1 className="text-2xl font-semibold">{organisation.name}</h1>
                {JSON.stringify(organisation)}
            </div>
        </>
    );
};

EditOrganisation.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default EditOrganisation;
