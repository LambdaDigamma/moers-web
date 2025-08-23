import { EditEventHeader } from '@/pages/events/edit-event-header';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';
import Organisation = Modules.Management.Data.Organisation;
import Event = Modules.Events.Data.Event;

interface EditEventLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, ...props }: EditEventLayoutProps) => {
    return (
        <div {...props}>
            <EditEventHeader></EditEventHeader>
            {children}
        </div>
    );
};
