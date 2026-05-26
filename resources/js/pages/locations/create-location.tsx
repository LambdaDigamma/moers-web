import { LocationForm } from '@/pages/locations/location-form';

type ReturnToEvent = {
    id: number;
    name: string;
} | null;

export default function CreateLocation({ backUrl, returnToEvent }: { backUrl: string; returnToEvent: ReturnToEvent }) {
    return (
        <LocationForm
            mode="create"
            backUrl={backUrl}
            returnToEvent={returnToEvent}
        />
    );
}
