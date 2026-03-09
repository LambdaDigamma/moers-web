import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import { Head } from '@inertiajs/react';
import React from 'react';

type ShowOrganisationProps = {
    organisation: Modules.Management.Data.Organisation;
    canEdit?: boolean;
    canCreateEvents?: boolean;
};

const ShowOrganisation = ({ organisation, canEdit, canCreateEvents }: ShowOrganisationProps) => {
    return (
        <>
            <Head title={organisation.name} />
            <div className="px-4 py-12 sm:px-6 lg:px-8">
                <div className="max-w-3xl space-y-8">
                    <div className="space-y-4">
                        <h2 className="text-xl font-bold text-zinc-950 dark:text-white">Über uns</h2>
                        <p className="leading-relaxed whitespace-pre-line text-zinc-600 dark:text-zinc-400">{organisation.description}</p>
                    </div>

                    {/* Add more info like contact, social links etc here later */}
                </div>
            </div>
        </>
    );
};

ShowOrganisation.layout = (page: React.ReactNode) => (
    <AppLayout>
        <OrganisationLayout>{page}</OrganisationLayout>
    </AppLayout>
);

export default ShowOrganisation;
