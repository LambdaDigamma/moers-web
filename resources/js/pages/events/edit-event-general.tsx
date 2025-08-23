import { DefaultContainer } from '@/components/default-container';
import { Field } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';
import EditEventLayout from './edit-event-layout';

const EditEventGeneral = ({}) => {
    return (
        <div>
            <Head title="Edit event" />
            <DefaultContainer>
                <form className="mt-6">
                    <Field>
                        <Label>Name</Label>
                        <Input name="name" />
                    </Field>
                </form>
            </DefaultContainer>
        </div>
    );
};

EditEventGeneral.layout = (page: ReactNode) => (
    <AppLayout>
        <EditEventLayout>{page}</EditEventLayout>
    </AppLayout>
);

export default EditEventGeneral;
