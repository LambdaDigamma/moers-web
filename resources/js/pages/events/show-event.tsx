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

            <DefaultContainer className="pb-16">
                <main className="space-y-8 py-8">
                    <div>
                        <Button
                            asChild
                            variant="ghost"
                            className="-ml-3"
                        >
                            <Link href={backUrl}>
                                <ChevronLeft className="size-4" />
                                Zurück zur Liste
                            </Link>
                        </Button>
                    </div>

                    <section className="overflow-hidden rounded-[2rem] border border-zinc-200 bg-zinc-950 text-white shadow-sm dark:border-white/10">
                        <div className="relative">
                            {event.headerImageUrl ? (
                                <img
                                    src={event.headerImageUrl}
                                    alt={event.name}
                                    className="absolute inset-0 h-full w-full object-cover opacity-35"
                                />
                            ) : null}
                            <div className="absolute inset-0 bg-linear-to-br from-zinc-950 via-zinc-950/90 to-cyan-950/80" />

                            <div className="relative grid gap-8 p-6 lg:grid-cols-[minmax(0,1.6fr)_minmax(18rem,0.8fr)] lg:p-8">
                                <div className="space-y-6">
                                    <div className="flex flex-wrap gap-2">
                                        {primaryLabel ? <Badge variant="secondary">{primaryLabel}</Badge> : null}
                                        {collectionLabel && collectionLabel !== primaryLabel ? (
                                            <Badge variant="outline">{collectionLabel}</Badge>
                                        ) : null}
                                        {event.isOnline ? <Badge variant="outline">Online</Badge> : null}
                                    </div>

                                    <div className="space-y-3">
                                        <Heading className="text-4xl leading-tight text-white sm:text-5xl">{event.name}</Heading>
                                        {event.subtitle ? (
                                            <p className="text-sm font-medium tracking-[0.12em] text-amber-200 uppercase">{event.subtitle}</p>
                                        ) : null}
                                        {leadText ? <p className="max-w-3xl text-sm leading-7 text-zinc-200">{leadText}</p> : null}
                                    </div>

                                    {event.cancelledAt ? <EventCancelledBanner /> : null}

                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <FeaturePill
                                            icon={<CalendarDays className="size-4" />}
                                            label="Termin"
                                            value={
                                                event.startDate ? (
                                                    <AutoDateRange
                                                        start={event.startDate}
                                                        end={event.endDate}
                                                    />
                                                ) : (
                                                    'Termin wird noch bekanntgegeben'
                                                )
                                            }
                                        />
                                        <FeaturePill
                                            icon={<MapPin className="size-4" />}
                                            label="Ort"
                                            value={locationLabel ?? (event.isOnline ? 'Online-Veranstaltung' : 'Ort wird noch bekanntgegeben')}
                                        />
                                    </div>
                                </div>

                                <Card className="border-white/10 bg-white/10 py-0 text-white shadow-none backdrop-blur">
                                    <CardHeader className="px-6 pt-6">
                                        <CardTitle>Planen</CardTitle>
                                    </CardHeader>
                                    <CardContent className="space-y-5 px-6 pb-6">
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
                                                label="Ende"
                                                value={formatDateTime(event.endDate, { dateStyle: 'full', timeStyle: 'short' }) ?? 'n/v'}
                                            />
                                        ) : null}
                                        <DetailItem
                                            icon={<MapPin className="size-4" />}
                                            label="Adresse"
                                            value={addressLabel ?? locationLabel ?? (event.isOnline ? 'Online-Veranstaltung' : 'n/v')}
                                        />
                                        <div className="flex flex-wrap gap-3">
                                            {event.calendarUrl ? (
                                                <Button
                                                    asChild
                                                    variant="secondary"
                                                    className="bg-white text-zinc-950 hover:bg-white/90"
                                                >
                                                    <a
                                                        href={event.calendarUrl}
                                                        download={`${event.name}.ics`}
                                                    >
                                                        <Ticket className="size-4" />
                                                        Kalendereintrag
                                                    </a>
                                                </Button>
                                            ) : null}

                                            {mapsUrl ? (
                                                <Button
                                                    asChild
                                                    variant="outline"
                                                    className="border-white/15 bg-transparent text-white hover:bg-white/10 hover:text-white"
                                                >
                                                    <a
                                                        href={mapsUrl}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                    >
                                                        <MapPin className="size-4" />
                                                        Route öffnen
                                                    </a>
                                                </Button>
                                            ) : null}

                                            {event.url ? (
                                                <Button
                                                    asChild
                                                    variant="outline"
                                                    className="border-white/15 bg-transparent text-white hover:bg-white/10 hover:text-white"
                                                >
                                                    <a
                                                        href={event.url}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                    >
                                                        <ArrowUpRight className="size-4" />
                                                        Originalquelle
                                                    </a>
                                                </Button>
                                            ) : null}
                                        </div>
                                    </CardContent>
                                </Card>
                            </div>
                        </div>
                    </section>

                    <div className="grid gap-6 lg:grid-cols-[minmax(0,1.5fr)_minmax(18rem,0.9fr)]">
                        <div className="space-y-6">
                            <Card className="rounded-[2rem] py-0">
                                <CardHeader className="px-6 pt-6">
                                    <CardTitle>Über die Veranstaltung</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-5 px-6 pb-6">
                                    <p className="text-sm leading-7 whitespace-pre-line text-zinc-700 dark:text-zinc-300">
                                        {description ?? leadText ?? 'Zu dieser Veranstaltung liegt derzeit noch keine Beschreibung vor.'}
                                    </p>
                                    {event.artists.length > 0 ? (
                                        <div className="space-y-3 border-t border-zinc-200 pt-5 dark:border-white/10">
                                            <p className="text-xs font-medium tracking-[0.18em] text-zinc-500 uppercase dark:text-zinc-400">
                                                Mitwirkende
                                            </p>
                                            <div className="flex flex-wrap gap-2">
                                                {event.artists.map((artist) => (
                                                    <Badge
                                                        key={artist}
                                                        variant="outline"
                                                    >
                                                        {artist}
                                                    </Badge>
                                                ))}
                                            </div>
                                        </div>
                                    ) : null}
                                </CardContent>
                            </Card>
                        </div>

                        {hasPlanningSidebar ? (
                            <aside className="space-y-6 lg:sticky lg:top-24 lg:self-start">
                                <Card className="rounded-[2rem] py-0">
                                    <CardHeader className="px-6 pt-6">
                                        <CardTitle>Kontakt & Teilnahme</CardTitle>
                                    </CardHeader>
                                    <CardContent className="space-y-4 px-6 pb-6">
                                        {addressLabel || mapsUrl ? (
                                            <SidebarSection
                                                icon={<MapPin className="size-4" />}
                                                title="Anreise"
                                            >
                                                {locationLabel ? <p className="font-medium text-zinc-950 dark:text-white">{locationLabel}</p> : null}
                                                {addressLabel ? <p>{addressLabel}</p> : null}
                                                {mapsUrl ? (
                                                    <a
                                                        href={mapsUrl}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="inline-flex items-center gap-2 text-sm font-medium text-cyan-700 hover:text-cyan-600 dark:text-cyan-300 dark:hover:text-cyan-200"
                                                    >
                                                        <MapPin className="size-4" />
                                                        Navigation starten
                                                    </a>
                                                ) : null}
                                            </SidebarSection>
                                        ) : null}

                                        {hasOrganizerDetails ? (
                                            <SidebarSection
                                                icon={<UserRound className="size-4" />}
                                                title="Veranstalter"
                                            >
                                                <div className="flex items-center gap-3">
                                                    {event.organisationLogoPath ? (
                                                        <img
                                                            src={event.organisationLogoPath}
                                                            alt={event.organisationName ?? 'Organisation'}
                                                            className="size-12 rounded-full border border-zinc-200 bg-white object-cover dark:border-white/10"
                                                        />
                                                    ) : (
                                                        <div className="flex size-12 items-center justify-center rounded-full border border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-white/5">
                                                            <UserRound className="size-5 text-zinc-400" />
                                                        </div>
                                                    )}

                                                    <div className="min-w-0">
                                                        <p className="font-medium text-zinc-950 dark:text-white">
                                                            {event.organisationName ?? 'Organisation'}
                                                        </p>
                                                        {organizerAddress ? (
                                                            <p className="text-sm text-zinc-600 dark:text-zinc-300">{organizerAddress}</p>
                                                        ) : null}
                                                        {event.organisationSlug ? (
                                                            <Link
                                                                href={route('organisations.show', [event.organisationSlug])}
                                                                className="inline-flex items-center gap-1 text-sm text-cyan-700 hover:text-cyan-600 dark:text-cyan-300 dark:hover:text-cyan-200"
                                                            >
                                                                Profil ansehen
                                                                <ArrowUpRight className="size-4" />
                                                            </Link>
                                                        ) : null}
                                                    </div>
                                                </div>

                                                <div className="flex flex-col gap-2 text-sm">
                                                    {event.organizerPhone ? (
                                                        <a
                                                            href={`tel:${event.organizerPhone}`}
                                                            className="text-cyan-700 hover:text-cyan-600 dark:text-cyan-300 dark:hover:text-cyan-200"
                                                        >
                                                            {event.organizerPhone}
                                                        </a>
                                                    ) : null}
                                                    {event.organizerEmail ? (
                                                        <a
                                                            href={`mailto:${event.organizerEmail}`}
                                                            className="text-cyan-700 hover:text-cyan-600 dark:text-cyan-300 dark:hover:text-cyan-200"
                                                        >
                                                            {event.organizerEmail}
                                                        </a>
                                                    ) : null}
                                                    {event.organizerWebsite ? (
                                                        <a
                                                            href={event.organizerWebsite}
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            className="inline-flex items-center gap-1 text-cyan-700 hover:text-cyan-600 dark:text-cyan-300 dark:hover:text-cyan-200"
                                                        >
                                                            Webseite
                                                            <ArrowUpRight className="size-4" />
                                                        </a>
                                                    ) : null}
                                                </div>
                                            </SidebarSection>
                                        ) : null}

                                        {event.isOnline ? (
                                            <SidebarSection
                                                icon={<Globe className="size-4" />}
                                                title="Teilnahme"
                                            >
                                                <p>Diese Veranstaltung ist online verfügbar oder findet digital statt.</p>
                                            </SidebarSection>
                                        ) : null}
                                    </CardContent>
                                </Card>
                            </aside>
                        ) : null}
                    </div>
                </main>
            </DefaultContainer>
        </>
    );
};

function FeaturePill({ icon, label, value }: { icon: ReactNode; label: string; value: ReactNode }) {
    return (
        <div className="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
            <div className="flex items-center gap-2 text-xs font-medium tracking-[0.18em] text-zinc-300 uppercase">
                {icon}
                <span>{label}</span>
            </div>
            <div className="mt-2 text-sm leading-6 text-white">{value}</div>
        </div>
    );
}

function DetailItem({ icon, label, value }: { icon: ReactNode; label: string; value: ReactNode }) {
    return (
        <div className="space-y-1">
            <div className="flex items-center gap-2 text-xs font-medium tracking-[0.18em] text-zinc-300 uppercase">
                {icon}
                <span>{label}</span>
            </div>
            <div className="text-sm leading-6 text-white">{value}</div>
        </div>
    );
}

function SidebarSection({ icon, title, children }: { icon: ReactNode; title: string; children: ReactNode }) {
    return (
        <section className="space-y-3 border-b border-zinc-200 pb-4 last:border-b-0 last:pb-0 dark:border-white/10">
            <div className="flex items-center gap-2 text-xs font-medium tracking-[0.18em] text-zinc-500 uppercase dark:text-zinc-400">
                {icon}
                <span>{title}</span>
            </div>
            <div className="space-y-3 text-sm leading-6 text-zinc-700 dark:text-zinc-300">{children}</div>
        </section>
    );
}

const EventCancelledBanner = () => {
    return <div className="rounded-2xl border border-red-400/40 bg-red-500/15 p-4 text-sm text-red-100">Diese Veranstaltung wurde abgesagt.</div>;
};

ShowEvent.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ShowEvent;
