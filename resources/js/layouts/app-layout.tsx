import { type AppHeaderVariant } from '@/components/app-header';
import AppLayoutTemplate from '@/layouts/app/app-header-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    headerVariant?: AppHeaderVariant;
}

export default ({ children, breadcrumbs, headerVariant, ...props }: AppLayoutProps) => (
    <AppLayoutTemplate
        breadcrumbs={breadcrumbs}
        headerVariant={headerVariant}
        {...props}
    >
        {children}
    </AppLayoutTemplate>
);
