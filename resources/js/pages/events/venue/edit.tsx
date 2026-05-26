import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ErrorMessage, Field } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { default as AppLayout } from '@/layouts/app-layout';
import EditEventLayout from '@/pages/events/edit-event-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { LoaderCircle, MapPin, Pencil, Plus } from 'lucide-react';
import { ReactNode, useId, useMemo, useState } from 'react';
import Event = Modules.Events.Data.Event;

type LocationOption = {
    id: number;
    name: string;
    address: string;
    url?: string | null;
    phone?: string | null;
    tags?: string;
    media_collections: {
        header?: App.Data.MediaData[];
    };
};

type SelectedLocation = LocationOption & {
    street_name?: string | null;
    street_number?: string | null;
    address_addition?: string | null;
    postalcode?: string | null;
    postal_town?: string | null;
    country_code?: string | null;
    url?: string | null;
    phone?: string | null;
    tags?: string;
};

const EditEventVenue = ({
    event,
    availableLocations,
    selectedLocationId,
    selectedLocation,
    canManageLocations,
}: {
    event: Event;
    availableLocations: LocationOption[];
    selectedLocationId: number | null;
    selectedLocation: SelectedLocation | null;
    canManageLocations: boolean;
}) => {
    const [locationFilter, setLocationFilter] = useState('');
    const venueSelectLabelId = useId();
    const form = useForm({
        place_id: selectedLocationId ? String(selectedLocationId) : null,
    });

    const filteredLocations = useMemo(() => {
        if (locationFilter.trim() === '') {
            return availableLocations;
        }

        const needle = locationFilter.toLowerCase();

        return availableLocations.filter((location) => [location.name, location.address].some((value) => value.toLowerCase().includes(needle)));
    }, [availableLocations, locationFilter]);

    const activeLocation = useMemo(() => {
        if (selectedLocation && String(selectedLocation.id) === form.data.place_id) {
            return selectedLocation;
        }

        return availableLocations.find((location) => String(location.id) === form.data.place_id) ?? null;
    }, [availableLocations, form.data.place_id, selectedLocation]);

    const selectedLocationEditUrl = activeLocation ? `/locations/${activeLocation.id}/edit?event=${event.id}` : null;
    const createLocationUrl = `/locations/create?event=${event.id}`;

    const saveVenueAssignment = () => form.put(route('events.place.update', [event.id]));

    return (
        <div>
            <Head title="Venue bearbeiten" />
            <DefaultContainer className="space-y-8 py-8">
                <Card className="rounded-3xl border-zinc-200 dark:border-white/10">
                    <CardHeader>
                        <CardTitle>Ort fuer die Veranstaltung</CardTitle>
                        <CardDescription>
                            Waehle den passenden Ort fuer {event.name} aus. Wenn etwas fehlt, kannst du direkt von hier einen neuen Ort anlegen oder
                            den ausgewaehlten Ort pflegen.
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <Field>
                            <Label htmlFor="venue-filter">Orte filtern</Label>
                            <Input
                                id="venue-filter"
                                value={locationFilter}
                                onChange={(event) => setLocationFilter(event.target.value)}
                                placeholder="Nach Name oder Adresse suchen"
                            />
                        </Field>

                        <Field>
                            <Label id={venueSelectLabelId}>Ort auswaehlen</Label>
                            <Select
                                value={form.data.place_id ?? undefined}
                                onValueChange={(value) => form.setData('place_id', value === 'none' ? null : value)}
                            >
                                <SelectTrigger
                                    aria-labelledby={venueSelectLabelId}
                                    className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950"
                                >
                                    <SelectValue placeholder="Ort auswaehlen" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="none">Kein Ort</SelectItem>
                                    {filteredLocations.map((location) => (
                                        <SelectItem
                                            key={location.id}
                                            value={String(location.id)}
                                        >
                                            {location.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            {form.errors.place_id ? <ErrorMessage>{form.errors.place_id}</ErrorMessage> : null}
                        </Field>

                        <div className="flex flex-wrap gap-3">
                            <Button
                                type="button"
                                onClick={saveVenueAssignment}
                                disabled={form.processing}
                            >
                                {form.processing ? <LoaderCircle className="size-4 animate-spin" /> : null}
                                Zu Veranstaltung speichern
                            </Button>

                            {canManageLocations ? (
                                <Button
                                    asChild
                                    type="button"
                                    variant="outline"
                                >
                                    <Link href={createLocationUrl}>
                                        <Plus className="size-4" />
                                        Neuen Ort anlegen
                                    </Link>
                                </Button>
                            ) : null}

                            {canManageLocations && selectedLocationEditUrl ? (
                                <Button
                                    asChild
                                    type="button"
                                    variant="outline"
                                >
                                    <Link href={selectedLocationEditUrl}>
                                        <Pencil className="size-4" />
                                        Ausgewaehlten Ort bearbeiten
                                    </Link>
                                </Button>
                            ) : null}
                        </div>
                    </CardContent>
                </Card>

                {activeLocation ? (
                    <Card className="overflow-hidden rounded-3xl border-zinc-200 dark:border-white/10">
                        <div className="grid gap-0 lg:grid-cols-[minmax(0,420px)_1fr]">
                            <div className="relative min-h-64 bg-zinc-100 dark:bg-white/5">
                                {activeLocation.media_collections.header?.[0] ? (
                                    <img
                                        src={activeLocation.media_collections.header[0].full_url}
                                        alt={activeLocation.media_collections.header[0].alt ?? activeLocation.name}
                                        className="h-full w-full object-cover"
                                    />
                                ) : (
                                    <div className="flex h-full items-center justify-center text-sm text-zinc-500 dark:text-zinc-400">
                                        Kein Header-Bild hinterlegt
                                    </div>
                                )}
                            </div>

                            <CardContent className="space-y-4 p-6">
                                <div className="space-y-2">
                                    <div className="inline-flex items-center gap-2 rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600 dark:bg-white/10 dark:text-zinc-300">
                                        <MapPin className="size-3.5" />
                                        Ort
                                    </div>
                                    <h2 className="text-2xl font-semibold text-zinc-950 dark:text-white">{activeLocation.name}</h2>
                                    <p className="text-sm text-zinc-500 dark:text-zinc-400">{activeLocation.address || 'Keine Adresse hinterlegt'}</p>
                                </div>

                                <dl className="grid gap-4 text-sm text-zinc-600 sm:grid-cols-2 dark:text-zinc-300">
                                    <div>
                                        <dt className="font-medium text-zinc-950 dark:text-white">Bilder</dt>
                                        <dd>{activeLocation.media_collections.header?.length ?? 0} hinterlegt</dd>
                                    </div>
                                    <div>
                                        <dt className="font-medium text-zinc-950 dark:text-white">Website</dt>
                                        <dd>{activeLocation.url || 'Keine Website'}</dd>
                                    </div>
                                    <div>
                                        <dt className="font-medium text-zinc-950 dark:text-white">Telefon</dt>
                                        <dd>{activeLocation.phone || 'Keine Telefonnummer'}</dd>
                                    </div>
                                    <div>
                                        <dt className="font-medium text-zinc-950 dark:text-white">Tags</dt>
                                        <dd>{activeLocation.tags || 'Keine Tags'}</dd>
                                    </div>
                                </dl>
                            </CardContent>
                        </div>
                    </Card>
                ) : null}
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
