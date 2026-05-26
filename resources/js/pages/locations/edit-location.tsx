import { LocationForm } from '@/pages/locations/location-form';

type ReturnToEvent = {
    id: number;
    name: string;
} | null;

type EditableLocation = {
    id: number;
    name: string;
    lat: number;
    lng: number;
    street_name: string | null;
    street_number: string | null;
    address_addition: string | null;
    postalcode: string | null;
    postal_town: string | null;
    country_code: string | null;
    tags: string;
    url: string | null;
    phone: string | null;
    media_collections: {
        header?: App.Data.MediaData[];
    };
};

export default function EditLocation({
    location,
    backUrl,
    returnToEvent,
}: {
    location: EditableLocation;
    backUrl: string;
    returnToEvent: ReturnToEvent;
}) {
    return (
        <LocationForm
            mode="edit"
            location={location}
            backUrl={backUrl}
            returnToEvent={returnToEvent}
        />
    );
}
