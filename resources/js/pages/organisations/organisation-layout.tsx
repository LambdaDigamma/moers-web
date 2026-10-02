import { DetailHeader } from '@/components/detail-header';
import { Button } from '@/components/ui/button-catalyst';
import { EditOrganisationNavigation } from '@/pages/organisations/edit-organisation-navigation';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { UserRound } from 'lucide-react';
import { type ReactNode } from 'react';
import Organisation = Modules.Management.Data.Organisation;

interface OrganisationLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

interface Props {
    organisation: Organisation;
    canEdit?: boolean;
    canCreateEvents?: boolean;
}

export default ({ children, ...props }: OrganisationLayoutProps) => {
    const { organisation, canEdit } = usePage<SharedData & Props>().props;

    return (
        <div {...props}>
            <DetailHeader
                content={
                    <div className="flex items-start gap-4 sm:items-center sm:gap-6">
                        <div className="border-border bg-muted size-14 shrink-0 overflow-hidden rounded-lg border sm:size-20">
                            {organisation.logoPath ? (
                                <img
                                    src={organisation.logoPath}
                                    alt={organisation.name}
                                    className="h-full w-full object-cover"
                                />
                            ) : (
                                <div className="flex h-full w-full items-center justify-center">
                                    <UserRound className="size-10 text-zinc-300 dark:text-zinc-700" />
                                </div>
                            )}
                        </div>
                        <div className="flex min-w-0 flex-col gap-2">
                            <h1 className="font-display tracking-heading text-foreground text-2xl leading-tight font-semibold sm:text-4xl">
                                {organisation.name}
                            </h1>
                            <p className="text-muted-foreground line-clamp-2 max-w-2xl">{organisation.description}</p>
                        </div>
                    </div>
                }
                actions={canEdit && <Button href={route('organisations.edit', [organisation.slug])}>Bearbeiten</Button>}
                navigation={
                    <EditOrganisationNavigation overviewRoute={route().current('organisations.edit') ? 'organisations.edit' : 'organisations.show'} />
                }
            ></DetailHeader>
            {children}
        </div>
    );
};
