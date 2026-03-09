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
                    <div className="flex items-center gap-6">
                        <div className="aspect-square w-20 shrink-0 overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100 dark:border-white/5 dark:bg-white/10">
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
                        <div className="space-y-1">
                            <h1 className="text-3xl font-bold tracking-tight text-zinc-950 dark:text-white">{organisation.name}</h1>
                            <p className="line-clamp-2 max-w-2xl text-zinc-600 dark:text-zinc-400">{organisation.description}</p>
                        </div>
                    </div>
                }
                actions={canEdit && <Button href={route('organisations.edit', [organisation.slug])}>Bearbeiten</Button>}
                navigation={<EditOrganisationNavigation />}
            ></DetailHeader>
            {children}
        </div>
    );
};
