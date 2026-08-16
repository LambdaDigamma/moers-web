import { DefaultContainer } from '@/components/default-container';
import { SeoHead } from '@/components/seo-head';
import { default as AppLayout } from '@/layouts/app-layout';
import OrganisationLayout from '@/pages/organisations/organisation-layout';
import React from 'react';

type ShowOrganisationProps = {
    organisation: Modules.Management.Data.Organisation;
    canEdit?: boolean;
    canCreateEvents?: boolean;
};

const ShowOrganisation = ({ organisation, canEdit, canCreateEvents }: ShowOrganisationProps) => {
    return (
        <>
            <SeoHead
                title={organisation.name}
                description={organisation.description || `${organisation.name} stellt sich vor und informiert über Angebote in Moers.`}
                imageUrl={organisation.logoPath}
            />
            <DefaultContainer className="py-12">
                <div className="max-w-3xl space-y-8">
                    <div className="space-y-4">
                        <h2 className="text-xl font-bold text-zinc-950 dark:text-white">Über uns</h2>
                        <p className="leading-relaxed whitespace-pre-line text-zinc-600 dark:text-zinc-400">{organisation.description}</p>
                    </div>

                    {/* Add more info like contact, social links etc here later */}
                </div>
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
