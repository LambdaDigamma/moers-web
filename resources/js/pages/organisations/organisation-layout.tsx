import { DetailHeader } from '@/components/detail-header';
import { Button } from '@/components/ui/button-catalyst';
import { Text } from '@/components/ui/text';
import { EditOrganisationNavigation } from '@/pages/organisations/edit-organisation-navigation';
import { type BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/react';
import { type ReactNode } from 'react';
import Organisation = Modules.Management.Data.Organisation;

interface OrganisationLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, ...props }: OrganisationLayoutProps) => {
    const organisation = usePage().props.organisation as Organisation;

    return (
        <div {...props}>
            <DetailHeader
                content={
                    <>
                        <div className="aspect-square w-16 shrink-0 overflow-hidden rounded-lg bg-zinc-100 dark:bg-white/10"></div>
                        <div>
                            <h1 className="font-medium">{organisation.name}</h1>
                            <Text>{organisation.description}</Text>
                        </div>
                    </>
                }
                actions={<Button href={route('organisations.edit', [organisation.slug])}>Edit</Button>}
                navigation={<EditOrganisationNavigation></EditOrganisationNavigation>}
            ></DetailHeader>
            {children}
        </div>
    );
};
