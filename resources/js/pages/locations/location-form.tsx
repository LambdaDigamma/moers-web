import { DefaultContainer } from '@/components/default-container';
import { EditableMediaItem, LocationMediaEditor, editableMediaItemFromServer } from '@/components/location-media-editor';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ErrorMessage, Field, FieldGroup } from '@/components/ui/fieldset';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { LoaderCircle, MapPin, Trash2 } from 'lucide-react';
import { FormEvent } from 'react';

type ReturnToEvent = {
    id: number;
    name: string;
};

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

type LocationFormData = {
    _method?: 'put';
    name: string;
    lat: string;
    lng: string;
    street_name: string;
    street_number: string;
    address_addition: string;
    postalcode: string;
    postal_town: string;
    country_code: string;
    tags: string;
    url: string;
    phone: string;
    return_to_event: number | null;
    sync_media: boolean;
    media: EditableMediaItem[];
};

type LocationFormProps = {
    mode: 'create' | 'edit';
    backUrl: string;
    returnToEvent: ReturnToEvent | null;
    location?: EditableLocation;
};

export function LocationForm({ mode, backUrl, returnToEvent, location }: LocationFormProps) {
    const form = useForm<LocationFormData>({
        name: location?.name ?? '',
        lat: location?.lat?.toString() ?? '',
        lng: location?.lng?.toString() ?? '',
        street_name: location?.street_name ?? '',
        street_number: location?.street_number ?? '',
        address_addition: location?.address_addition ?? '',
        postalcode: location?.postalcode ?? '',
        postal_town: location?.postal_town ?? '',
        country_code: location?.country_code ?? 'DE',
        tags: location?.tags ?? '',
        url: location?.url ?? '',
        phone: location?.phone ?? '',
        return_to_event: returnToEvent?.id ?? null,
        sync_media: true,
        media: (location?.media_collections.header ?? []).map((media) => editableMediaItemFromServer(media)),
    });

    const mediaError = form.errors.media ?? Object.entries(form.errors).find(([key]) => key.startsWith('media.'))?.[1] ?? undefined;
    const locationError = (form.errors as Record<string, string | undefined>).location;

    const submit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (mode === 'create') {
            form.post(route('locations.store'));
            return;
        }

        form.transform((data) => ({ ...data, _method: 'put' }));
        form.post(route('locations.update', location!.id), {
            forceFormData: true,
            onFinish: () => form.transform((data) => data),
        });
    };

    const destroyLocation = () => {
        if (!location || !window.confirm('Soll dieser Ort wirklich geloescht werden?')) {
            return;
        }

        router.delete(route('locations.destroy', location.id), {
            data: {
                return_to_event: returnToEvent?.id ?? null,
            },
        });
    };

    return (
        <AppLayout>
            <Head title={mode === 'create' ? 'Ort erstellen' : `Ort bearbeiten: ${location?.name ?? ''}`} />

            <DefaultContainer className="space-y-8 py-8">
                <div className="flex flex-wrap items-start justify-between gap-4">
                    <div className="space-y-2">
                        <div className="inline-flex items-center gap-2 rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600 dark:bg-white/10 dark:text-zinc-300">
                            <MapPin className="size-3.5" />
                            Orte
                        </div>
                        <h1 className="text-3xl font-semibold text-zinc-950 dark:text-white">
                            {mode === 'create' ? 'Ort erstellen' : location?.name}
                        </h1>
                        <p className="max-w-2xl text-sm text-zinc-500 dark:text-zinc-400">
                            {returnToEvent
                                ? `Du bearbeitest einen Ort fuer die Veranstaltung "${returnToEvent.name}".`
                                : 'Pflege Stammdaten und Header-Bilder fuer einen Ort.'}
                        </p>
                    </div>

                    <div className="flex flex-wrap gap-2">
                        <Button
                            asChild
                            variant="outline"
                        >
                            <Link href={backUrl}>Zurueck</Link>
                        </Button>

                        {mode === 'edit' ? (
                            <Button
                                type="button"
                                variant="destructive"
                                onClick={destroyLocation}
                            >
                                <Trash2 className="size-4" />
                                Loeschen
                            </Button>
                        ) : null}
                    </div>
                </div>

                <form
                    className="space-y-8"
                    onSubmit={submit}
                >
                    <Card className="rounded-3xl border-zinc-200 dark:border-white/10">
                        <CardHeader>
                            <CardTitle>Stammdaten</CardTitle>
                            <CardDescription>Die wichtigsten Daten fuer Karten, Detailansichten und Suche.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <FieldGroup className="grid gap-6 md:grid-cols-2">
                                <Field className="md:col-span-2">
                                    <Label htmlFor="location-name">Name</Label>
                                    <Input
                                        id="location-name"
                                        value={form.data.name}
                                        onChange={(event) => form.setData('name', event.target.value)}
                                        invalid={Boolean(form.errors.name)}
                                    />
                                    {form.errors.name ? <ErrorMessage>{form.errors.name}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-lat">Breitengrad</Label>
                                    <Input
                                        id="location-lat"
                                        type="number"
                                        step="any"
                                        value={form.data.lat}
                                        onChange={(event) => form.setData('lat', event.target.value)}
                                        invalid={Boolean(form.errors.lat)}
                                    />
                                    {form.errors.lat ? <ErrorMessage>{form.errors.lat}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-lng">Laengengrad</Label>
                                    <Input
                                        id="location-lng"
                                        type="number"
                                        step="any"
                                        value={form.data.lng}
                                        onChange={(event) => form.setData('lng', event.target.value)}
                                        invalid={Boolean(form.errors.lng)}
                                    />
                                    {form.errors.lng ? <ErrorMessage>{form.errors.lng}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-street-name">Strasse</Label>
                                    <Input
                                        id="location-street-name"
                                        value={form.data.street_name}
                                        onChange={(event) => form.setData('street_name', event.target.value)}
                                        invalid={Boolean(form.errors.street_name)}
                                    />
                                    {form.errors.street_name ? <ErrorMessage>{form.errors.street_name}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-street-number">Hausnummer</Label>
                                    <Input
                                        id="location-street-number"
                                        value={form.data.street_number}
                                        onChange={(event) => form.setData('street_number', event.target.value)}
                                        invalid={Boolean(form.errors.street_number)}
                                    />
                                    {form.errors.street_number ? <ErrorMessage>{form.errors.street_number}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-address-addition">Adresszusatz</Label>
                                    <Input
                                        id="location-address-addition"
                                        value={form.data.address_addition}
                                        onChange={(event) => form.setData('address_addition', event.target.value)}
                                        invalid={Boolean(form.errors.address_addition)}
                                    />
                                    {form.errors.address_addition ? <ErrorMessage>{form.errors.address_addition}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-postalcode">PLZ</Label>
                                    <Input
                                        id="location-postalcode"
                                        value={form.data.postalcode}
                                        onChange={(event) => form.setData('postalcode', event.target.value)}
                                        invalid={Boolean(form.errors.postalcode)}
                                    />
                                    {form.errors.postalcode ? <ErrorMessage>{form.errors.postalcode}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-postal-town">Ort</Label>
                                    <Input
                                        id="location-postal-town"
                                        value={form.data.postal_town}
                                        onChange={(event) => form.setData('postal_town', event.target.value)}
                                        invalid={Boolean(form.errors.postal_town)}
                                    />
                                    {form.errors.postal_town ? <ErrorMessage>{form.errors.postal_town}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-country-code">Land</Label>
                                    <Input
                                        id="location-country-code"
                                        value={form.data.country_code}
                                        onChange={(event) => form.setData('country_code', event.target.value.toUpperCase())}
                                        invalid={Boolean(form.errors.country_code)}
                                    />
                                    {form.errors.country_code ? <ErrorMessage>{form.errors.country_code}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-url">Website</Label>
                                    <Input
                                        id="location-url"
                                        type="url"
                                        value={form.data.url}
                                        onChange={(event) => form.setData('url', event.target.value)}
                                        invalid={Boolean(form.errors.url)}
                                    />
                                    {form.errors.url ? <ErrorMessage>{form.errors.url}</ErrorMessage> : null}
                                </Field>

                                <Field>
                                    <Label htmlFor="location-phone">Telefon</Label>
                                    <Input
                                        id="location-phone"
                                        type="tel"
                                        value={form.data.phone}
                                        onChange={(event) => form.setData('phone', event.target.value)}
                                        invalid={Boolean(form.errors.phone)}
                                    />
                                    {form.errors.phone ? <ErrorMessage>{form.errors.phone}</ErrorMessage> : null}
                                </Field>

                                <Field className="md:col-span-2">
                                    <Label htmlFor="location-tags">Tags</Label>
                                    <Input
                                        id="location-tags"
                                        value={form.data.tags}
                                        onChange={(event) => form.setData('tags', event.target.value)}
                                        invalid={Boolean(form.errors.tags)}
                                    />
                                    {form.errors.tags ? <ErrorMessage>{form.errors.tags}</ErrorMessage> : null}
                                </Field>
                            </FieldGroup>
                        </CardContent>
                    </Card>

                    <Card className="rounded-3xl border-zinc-200 dark:border-white/10">
                        <CardHeader>
                            <CardTitle>Medien</CardTitle>
                            <CardDescription>Mehrere Header-Bilder inklusive Reihenfolge und Zusatzinformationen.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <LocationMediaEditor
                                items={form.data.media}
                                onChange={(items) => form.setData('media', items)}
                                error={mediaError}
                            />
                        </CardContent>
                    </Card>

                    {locationError ? <ErrorMessage>{locationError}</ErrorMessage> : null}

                    <div className="flex flex-wrap justify-end gap-3">
                        <Button
                            asChild
                            variant="outline"
                        >
                            <Link href={backUrl}>Abbrechen</Link>
                        </Button>
                        <Button
                            type="submit"
                            disabled={form.processing}
                        >
                            {form.processing ? <LoaderCircle className="size-4 animate-spin" /> : null}
                            {mode === 'create' ? 'Ort erstellen' : 'Ort speichern'}
                        </Button>
                    </div>
                </form>
            </DefaultContainer>
        </AppLayout>
    );
}
