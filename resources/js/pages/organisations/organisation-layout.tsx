import { EditOrganisationNavigation } from '@/pages/organisations/edit-organisation-navigation';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface OrganisationLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, ...props }: OrganisationLayoutProps) => (
    <div {...props}>
        <EditOrganisationNavigation></EditOrganisationNavigation>
        {children}
    </div>
);
