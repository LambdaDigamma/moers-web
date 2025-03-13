import { DefaultContainer } from '@/components/default-container';
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
            <div className="border-b border-gray-200 dark:border-white/10">
                <DefaultContainer>
                    <div className="flex flex-row items-center space-x-4 pt-5 pb-3">
                        <div className="aspect-square w-16 shrink-0 overflow-hidden rounded-lg bg-zinc-100 dark:bg-white/10"></div>
                        <div>
                            <h1 className="font-medium">{organisation.name}</h1>
                            <Text>{organisation.description}</Text>
                        </div>
                    </div>
                    <EditOrganisationNavigation className="-mx-2"></EditOrganisationNavigation>
                </DefaultContainer>
            </div>

            {children}
        </div>
    );
};
