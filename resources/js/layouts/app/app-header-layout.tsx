import { AppContent } from '@/components/app-content';
import { AppFooter } from '@/components/app-footer';
import { AppHeader, type AppHeaderVariant } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';
import { type BreadcrumbItem } from '@/types';
import type { PropsWithChildren } from 'react';

export default function AppHeaderLayout({
    children,
    breadcrumbs,
    headerVariant,
}: PropsWithChildren<{ breadcrumbs?: BreadcrumbItem[]; headerVariant?: AppHeaderVariant }>) {
    return (
        <AppShell>
            <AppHeader
                breadcrumbs={breadcrumbs}
                variant={headerVariant}
            />
            <AppContent>{children}</AppContent>
            <AppFooter />
        </AppShell>
    );
}
