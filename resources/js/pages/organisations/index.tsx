import { DefaultContainer } from '@/components/default-container';
import { Heading } from '@/components/ui/heading';
import { Link } from '@/components/ui/link';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { usePaginator } from 'momentum-paginator';
import { ReactNode } from 'react';
import Organisation = Modules.Management.Data.Organisation;

const OrganisationIndex = ({ organisations }: { organisations: Paginator<Organisation> }) => {
    const { items } = usePaginator(organisations);

    return (
        <>
            <Head title="Organisationen"></Head>
            <DefaultContainer className="mt-8">
                <Heading>Organisations</Heading>
                <ul>
                    {organisations.data.map((organisation) => (
                        <li key={organisation.id}>
                            <Link href={route('organisations.edit', [organisation.slug])}>{organisation.name}</Link>
                        </li>
                    ))}
                </ul>
            </DefaultContainer>
        </>
    );
};

OrganisationIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default OrganisationIndex;
