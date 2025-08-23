import { DefaultContainer } from '@/components/default-container';
import { default as AppLayout } from '@/layouts/app-layout';
import EditEventLayout from '@/pages/events/edit-event-layout';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';

const EditEventVenue = ({}) => {
    return (
        <div>
            <Head title="Edit Venue" />
            <DefaultContainer>
                <p>Test</p>
            </DefaultContainer>
        </div>
    );
};

EditEventVenue.layout = (page: ReactNode) => (
    <AppLayout>
        <EditEventLayout>{page}</EditEventLayout>
    </AppLayout>
);

export default EditEventVenue;
