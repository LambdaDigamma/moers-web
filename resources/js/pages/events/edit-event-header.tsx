import { DetailHeader } from '@/components/detail-header';
import { EditEventNavigation } from '@/pages/events/edit-event-navigation';
import { usePage } from '@inertiajs/react';
import Event = Modules.Events.Data.Event;

const EditEventHeader = () => {
    const event = usePage().props.event as Event;

    return (
        <DetailHeader
            content={
                <>
                    <div>
                        {event.name}
                        {/*<h1 className="font-medium">{organisation.name}</h1>*/}
                        {/*<Text>{organisation.description}</Text>*/}
                    </div>
                </>
            }
            navigation={<EditEventNavigation></EditEventNavigation>}
        ></DetailHeader>
    );
};

export { EditEventHeader };
