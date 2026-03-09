import { AutoDateRange } from '@/components/auto-timerange';
import { DefaultContainer } from '@/components/default-container';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Heading } from '@/components/ui/heading';
import AppLayout from '@/layouts/app-layout';
import { formatDateTime } from '@/lib/date';
import { formatCollectionLabel, getEventAddressLabel, getEventLocationLabel, getEventMapsUrl, getEventPrimaryLabel } from '@/lib/events';
import { Head, Link } from '@inertiajs/react';
import { ArrowUpRight, CalendarDays, ChevronLeft, Globe, MapPin, Ticket, UserRound } from 'lucide-react';
import { ReactNode } from 'react';
import Event = Modules.Events.Data.Event;

const ShowEvent = ({ event, backUrl }: { event: Event; backUrl: string }) => {
    const primaryLabel = getEventPrimaryLabel(event);
    const collectionLabel = formatCollectionLabel(event.collection);
    const locationLabel = getEventLocationLabel(event);
    const addressLabel = getEventAddressLabel(event);
    const mapsUrl = getEventMapsUrl(event);
    const description = event.description?.trim() ?? null;
    const normalizedDescription = description?.replace(/\s+/g, ' ').trim() ?? null;
    const normalizedExcerpt = event.excerpt?.replace(/\s+/g, ' ').trim() ?? null;
    const leadText = event.teaser?.trim() ?? (normalizedExcerpt && normalizedExcerpt !== normalizedDescription ? event.excerpt : null);
    const organizerAddress = [event.organizerStreet, [event.organizerPostcode, event.organizerCity].filter(Boolean).join(' ')]
        .filter(Boolean)
        .join(', ');
    const hasOrganizerDetails = Boolean(
        event.organisationName ||
        event.organisationSlug ||
        organizerAddress ||
        event.organizerPhone ||
        event.organizerEmail ||
        event.organizerWebsite,
    );
    const hasPlanningSidebar = Boolean(addressLabel || mapsUrl || hasOrganizerDetails || event.isOnline);

    return (
        <>
            <Head title={event.name} />

            <div className="min-h-screen bg-white dark:bg-zinc-950">
                {/* Header Section */}
                <header className="border-b border-zinc-200 bg-zinc-50 py-12 dark:border-white/5 dark:bg-zinc-900/50">
                    <DefaultContainer>
                        <div className="mb-8 flex">
                            <Button
                                asChild
                                variant="ghost"
                                size="sm"
                                className="-ml-3 h-8 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200"
                            >
                                <Link href={backUrl}>
                                    <ChevronLeft className="mr-1 size-4" />
                                    Zurück zur Übersicht
                                </Link>
                            </Button>
                        </div>

                        <div className="grid gap-12 lg:grid-cols-[1fr_400px]">
                            <div className="flex flex-col justify-center space-y-6">
                                <div className="flex flex-wrap gap-2">
                                    {primaryLabel ? (
                                        <Badge className="bg-emerald-600 text-white shadow-none">
                                            {primaryLabel}
                                        </Badge>
                                    ) : null}
                                    {collectionLabel && collectionLabel !== primaryLabel ? (
                                        <Badge
                                            variant="secondary"
                                            className="bg-zinc-200 text-zinc-700 dark:bg-white/10 dark:text-zinc-300"
                                        >
                                            {collectionLabel}
                                        </Badge>
                                    ) : null}
                                </div>

                                <div className="space-y-4">
                                    <Heading className="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl lg:text-6xl dark:text-white">
                                        {event.name}
                                    </Heading>
                                    {event.subtitle ? (
                                        <p className="text-lg font-medium text-emerald-600 dark:text-emerald-400 sm:text-xl">
                                            {event.subtitle}
                                        </p>
                                    ) : null}
                                </div>

                                {/* Sneak Peek Info */}
                                <div className="flex flex-wrap items-center gap-x-8 gap-y-4 pt-2">
                                    <div className="flex items-center gap-2.5">
                                        <div className="flex size-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-zinc-200 dark:bg-white/5 dark:ring-white/10">
                                            <CalendarDays className="size-5 text-zinc-500 dark:text-zinc-400" />
                                        </div>
                                        <div>
                                            <p className="text-xs font-medium text-zinc-500 dark:text-zinc-400">Datum</p>
                                            <div className="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                                {event.startDate ? (
                                                    <AutoDateRange
                                                        start={event.startDate}
                                                        end={event.endDate}
                                                    />
                                                ) : (
                                                    'Termin offen'
                                                )}
                                            </div>
                                        </div>
                                    </div>

                                    <div className="flex items-center gap-2.5">
                                        <div className="flex size-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-zinc-200 dark:bg-white/5 dark:ring-white/10">
                                            <MapPin className="size-5 text-zinc-500 dark:text-zinc-400" />
                                        </div>
                                        <div>
                                            <p className="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ort</p>
                                            <p className="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                                {locationLabel ?? (event.isOnline ? 'Online' : 'Moers')}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {event.cancelledAt ? (
                                    <div className="inline-flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 ring-1 ring-red-200 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/20">
                                        Absage: Diese Veranstaltung fällt leider aus.
                                    </div>
                                ) : null}
                            </div>

                            {event.headerImageUrl ? (
                                <div className="relative aspect-[4/3] w-full overflow-hidden rounded-3xl bg-zinc-200 shadow-2xl dark:bg-white/5">
                                    <img
                                        src={event.headerImageUrl}
                                        alt={event.name}
                                        className="h-full w-full object-cover"
                                    />
                                </div>
                            ) : null}
                        </div>
                    </DefaultContainer>
                </header>

                <DefaultContainer className="py-16">
                    <div className="grid gap-12 lg:grid-cols-[1fr_360px]">
                        {/* Main Content */}
                        <div className="space-y-12">
                            {leadText ? (
                                <div className="border-l-4 border-emerald-500 pl-6">
                                    <p className="text-xl font-medium leading-relaxed text-zinc-800 dark:text-zinc-200 italic">
                                        {leadText}
                                    </p>
                                </div>
                            ) : null}

                            <section className="space-y-6">
                                <Heading className="text-2xl font-bold text-zinc-950 dark:text-white">Über die Veranstaltung</Heading>
                                <div className="prose prose-zinc dark:prose-invert max-w-none">
                                    <p className="text-lg leading-8 whitespace-pre-line text-zinc-700 dark:text-zinc-300">
                                        {description ?? 'Zu dieser Veranstaltung liegt derzeit noch keine ausführliche Beschreibung vor.'}
                                    </p>
                                </div>
                            </section>

                            {event.artists.length > 0 ? (
                                <section className="space-y-6 pt-6 border-t border-zinc-100 dark:border-white/5">
                                    <Heading className="text-xl font-bold text-zinc-950 dark:text-white">Mitwirkende</Heading>
                                    <div className="flex flex-wrap gap-2">
                                        {event.artists.map((artist) => (
                                            <Badge
                                                key={artist}
                                                variant="outline"
                                                className="rounded-lg px-3 py-1 text-sm border-zinc-200 dark:border-white/10"
                                            >
                                                {artist}
                                            </Badge>
                                        ))}
                                    </div>
                                </section>
                            ) : null}
                        </div>

                        {/* Sidebar */}
                        <aside className="space-y-8">
                            <Card className="rounded-3xl border-zinc-200 bg-zinc-50/50 p-2 shadow-sm dark:border-white/5 dark:bg-zinc-900/50">
                                <CardHeader className="px-6 pt-6 pb-2">
                                    <CardTitle className="text-sm font-semibold text-zinc-950 dark:text-white">Informationen</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-6 px-6 pb-6 pt-2">
                                    <div className="space-y-5">
                                        <DetailItem
                                            icon={<CalendarDays className="size-4" />}
                                            label="Beginn"
                                            value={
                                                event.startDate
                                                    ? (formatDateTime(event.startDate, { dateStyle: 'full', timeStyle: 'short' }) ?? 'n/v')
                                                    : 'n/v'
                                            }
                                        />
                                        {event.endDate ? (
                                            <DetailItem
                                                icon={<CalendarDays className="size-4" />}
                                                label="Voraussichtliches Ende"
                                                value={formatDateTime(event.endDate, { dateStyle: 'full', timeStyle: 'short' }) ?? 'n/v'}
                                            />
                                        ) : null}
                                        <DetailItem
                                            icon={<MapPin className="size-4" />}
                                            label="Anschrift"
                                            value={addressLabel ?? locationLabel ?? (event.isOnline ? 'Online-Veranstaltung' : 'n/v')}
                                        />
                                    </div>

                                    <div className="flex flex-col gap-2 pt-2">
                                        {event.calendarUrl ? (
                                            <Button
                                                asChild
                                                className="w-full justify-start rounded-xl bg-zinc-950 text-white hover:bg-zinc-800 dark:bg-emerald-600 dark:hover:bg-emerald-700"
                                            >
                                                <a
                                                    href={event.calendarUrl}
                                                    download={`${event.name}.ics`}
                                                >
                                                    <Ticket className="mr-2 size-4" />
                                                    Termin speichern
                                                </a>
                                            </Button>
                                        ) : null}

                                        {mapsUrl ? (
                                            <Button
                                                asChild
                                                variant="outline"
                                                className="w-full justify-start rounded-xl border-zinc-200 bg-white text-zinc-950 hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-white"
                                            >
                                                <a
                                                    href={mapsUrl}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                >
                                                    <MapPin className="mr-2 size-4" />
                                                    Anfahrt planen
                                                </a>
                                            </Button>
                                        ) : null}

                                        {event.url ? (
                                            <Button
                                                asChild
                                                variant="outline"
                                                className="w-full justify-start rounded-xl border-zinc-200 bg-white text-zinc-950 hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-white"
                                            >
                                                <a
                                                    href={event.url}
                                                    target="_blank"
                                                    rel="noreferrer"
                                                >
                                                    <ArrowUpRight className="mr-2 size-4" />
                                                    Website besuchen
                                                </a>
                                            </Button>
                                        ) : null}
                                    </div>
                                </CardContent>
                            </Card>

                            {hasOrganizerDetails ? (
                                <Card className="rounded-3xl border-zinc-200 bg-zinc-50/50 p-2 shadow-sm dark:border-white/5 dark:bg-zinc-900/50">
                                    <CardHeader className="px-6 pt-6 pb-2">
                                        <CardTitle className="text-sm font-semibold text-zinc-950 dark:text-white">Veranstalter</CardTitle>
                                    </CardHeader>                                    <CardContent className="space-y-6 px-6 pb-6 pt-2">
                                        <div className="flex items-center gap-4">
                                            {event.organisationLogoPath ? (
                                                <img
                                                    src={event.organisationLogoPath}
                                                    alt={event.organisationName ?? 'Organisation'}
                                                    className="size-12 rounded-xl border border-zinc-200 bg-white object-cover shadow-sm dark:border-white/10"
                                                />
                                            ) : (
                                                <div className="flex size-12 items-center justify-center rounded-xl border border-zinc-200 bg-white dark:border-white/10 dark:bg-white/5">
                                                    <UserRound className="size-5 text-zinc-400" />
                                                </div>
                                            )}

                                            <div className="min-w-0 flex-1">
                                                <p className="truncate font-bold text-zinc-950 dark:text-white">
                                                    {event.organisationName ?? 'Organisation'}
                                                </p>
                                                {event.organisationSlug ? (
                                                    <Link
                                                        href={route('organisations.show', [event.organisationSlug])}
                                                        className="mt-0.5 inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-500"
                                                    >
                                                        Profil anzeigen
                                                        <ArrowUpRight className="ml-1 size-3" />
                                                    </Link>
                                                ) : null}
                                            </div>
                                        </div>

                                        <div className="space-y-4 border-t border-zinc-200 pt-6 dark:border-white/10">
                                            {organizerAddress ? (
                                                <DetailItem
                                                    icon={<MapPin className="size-4 text-zinc-400" />}
                                                    label="Anschrift"
                                                    value={organizerAddress}
                                                />
                                            ) : null}
                                            {event.organizerPhone ? (
                                                <DetailItem
                                                    icon={<Globe className="size-4 text-zinc-400" />}
                                                    label="Telefon"
                                                    value={
                                                        <a
                                                            href={`tel:${event.organizerPhone}`}
                                                            className="hover:text-emerald-600"
                                                        >
                                                            {event.organizerPhone}
                                                        </a>
                                                    }
                                                />
                                            ) : null}
                                            {event.organizerEmail ? (
                                                <DetailItem
                                                    icon={<Globe className="size-4 text-zinc-400" />}
                                                    label="E-Mail"
                                                    value={
                                                        <a
                                                            href={`mailto:${event.organizerEmail}`}
                                                            className="hover:text-emerald-600"
                                                        >
                                                            {event.organizerEmail}
                                                        </a>
                                                    }
                                                />
                                            ) : null}
                                        </div>
                                    </CardContent>
                                </Card>
                            ) : null}
                        </aside>
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
};

function DetailItem({ icon, label, value }: { icon: ReactNode; label: string; value: ReactNode }) {
    return (
        <div className="space-y-1">
            <div className="flex items-center gap-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                <span className="text-zinc-400 dark:text-zinc-500">{icon}</span>
                <span>{label}</span>
            </div>
            <div className="text-sm font-medium text-zinc-950 dark:text-zinc-200 leading-relaxed">{value}</div>
        </div>
    );
}

ShowEvent.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ShowEvent;
