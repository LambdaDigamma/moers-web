import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { Button } from '@/components/ui/button';
import { Heading } from '@/components/ui/heading';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { formatCollectionLabel, getEventMonthGroupKey, getEventMonthGroupLabel } from '@/lib/events';
import { EventRow } from '@/pages/events/event-row';
import { type SharedData } from '@/types';
import { Head, InfiniteScroll, router, usePage } from '@inertiajs/react';
import { Search, X } from 'lucide-react';
import { ReactNode, useEffect, useState } from 'react';
import Event = Modules.Events.Data.Event;

type EventFilters = {
    search: string;
    type: string;
    collection: string;
    category: string;
    organisation: string;
    location: string;
};

type FilterOption = {
    value: string;
    label: string;
};

type EventsIndexProps = {
    events: Paginator<Event>;
    filters: EventFilters;
    availableFilters: {
        types: FilterOption[];
        collections: string[];
        categories: string[];
        organisations: FilterOption[];
        locations: FilterOption[];
    };
};

function groupEvents(events: Event[]): Array<{ key: string; label: string; events: Event[] }> {
    const groups = new Map<string, { key: string; label: string; events: Event[] }>();

    for (const event of events) {
        const key = getEventMonthGroupKey(event);

        if (!groups.has(key)) {
            groups.set(key, {
                key,
                label: getEventMonthGroupLabel(event),
                events: [],
            });
        }

        groups.get(key)?.events.push(event);
    }

    return Array.from(groups.values());
}

function normalizeFilters(filters: EventFilters): Record<string, string> {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== ''));
}

const EventsIndex = ({ events, filters, availableFilters }: EventsIndexProps) => {
    const page = usePage<SharedData>();
    const [values, setValues] = useState<EventFilters>(filters);

    useEffect(() => {
        setValues(filters);
    }, [filters]);

    const groupedEvents = groupEvents(events.data);
    const activeFilterCount = Object.entries(values).filter(([key, value]) => {
        if (key === 'type') {
            return value !== '' && value !== 'upcoming';
        }

        return value !== '';
    }).length;

    const applyFilters = (nextValues: EventFilters) => {
        router.get(route('events.index'), normalizeFilters(nextValues), {
            preserveState: true,
            preserveScroll: false,
            replace: true,
        });
    };

    const updateFilter = <T extends keyof EventFilters>(key: T, value: EventFilters[T]) => {
        const nextValues = {
            ...values,
            [key]: value,
        };

        setValues(nextValues);

        if (key !== 'search') {
            applyFilters(nextValues);
        }
    };

    const resetFilters = () => {
        const nextValues: EventFilters = {
            search: '',
            type: 'upcoming',
            collection: '',
            category: '',
            organisation: '',
            location: '',
        };

        setValues(nextValues);
        applyFilters(nextValues);
    };

    return (
        <>
            <Head title="Veranstaltungen" />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <PageHeader
                    badge="Terminkalender"
                    title="Veranstaltungen in Moers finden"
                    description="Entdecke kommende Termine, sortiert nach Monaten und filterbar nach deinen Interessen."
                >
                    <section className="rounded-[2.5rem] border border-zinc-200 bg-white p-6 shadow-xl dark:border-white/10 dark:bg-zinc-900">
                        <form
                            className="space-y-6"
                            onSubmit={(event) => {
                                event.preventDefault();
                                applyFilters(values);
                            }}
                        >
                            <div className="grid gap-6 lg:grid-cols-[minmax(0,1.4fr)_repeat(4,minmax(0,1fr))]">
                                <div className="space-y-2">
                                    <Label
                                        htmlFor="event-search"
                                        className="text-zinc-950 dark:text-white"
                                    >
                                        Suche
                                    </Label>
                                    <div className="relative">
                                        <Search className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-zinc-400" />
                                        <Input
                                            id="event-search"
                                            type="search"
                                            value={values.search}
                                            onChange={(event) => setValues((current) => ({ ...current, search: event.target.value }))}
                                            placeholder="Titel, Stichwort oder Reihe"
                                            className="h-11 rounded-xl border-zinc-200 bg-zinc-50 pl-9 dark:border-white/10 dark:bg-zinc-950"
                                        />
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Label
                                        htmlFor="event-type"
                                        className="text-zinc-950 dark:text-white"
                                    >
                                        Zeitraum
                                    </Label>
                                    <Select
                                        value={values.type || 'all'}
                                        onValueChange={(value) => updateFilter('type', value)}
                                    >
                                        <SelectTrigger
                                            id="event-type"
                                            className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950"
                                        >
                                            <SelectValue placeholder="Zeitraum wählen" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {availableFilters.types.map((option) => (
                                                <SelectItem
                                                    key={option.value}
                                                    value={option.value}
                                                >
                                                    {option.label}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="space-y-2">
                                    <Label
                                        htmlFor="event-collection"
                                        className="text-zinc-950 dark:text-white"
                                    >
                                        Reihe
                                    </Label>
                                    <Select
                                        value={values.collection || 'all'}
                                        onValueChange={(value) => updateFilter('collection', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger
                                            id="event-collection"
                                            className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950"
                                        >
                                            <SelectValue placeholder="Alle Reihen" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Alle Reihen</SelectItem>
                                            {availableFilters.collections.map((collection) => (
                                                <SelectItem
                                                    key={collection}
                                                    value={collection}
                                                >
                                                    {formatCollectionLabel(collection) ?? collection}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="space-y-2">
                                    <Label
                                        htmlFor="event-organisation"
                                        className="text-zinc-950 dark:text-white"
                                    >
                                        Veranstalter
                                    </Label>
                                    <Select
                                        value={values.organisation || 'all'}
                                        onValueChange={(value) => updateFilter('organisation', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger
                                            id="event-organisation"
                                            className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950"
                                        >
                                            <SelectValue placeholder="Alle Veranstalter" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Alle Veranstalter</SelectItem>
                                            {availableFilters.organisations.map((option) => (
                                                <SelectItem
                                                    key={option.value}
                                                    value={option.value}
                                                >
                                                    {option.label}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="space-y-2">
                                    <Label
                                        htmlFor="event-location"
                                        className="text-zinc-950 dark:text-white"
                                    >
                                        Ort
                                    </Label>
                                    <Select
                                        value={values.location || 'all'}
                                        onValueChange={(value) => updateFilter('location', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger
                                            id="event-location"
                                            className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950"
                                        >
                                            <SelectValue placeholder="Alle Orte" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Alle Orte</SelectItem>
                                            {availableFilters.locations.map((option) => (
                                                <SelectItem
                                                    key={option.value}
                                                    value={option.value}
                                                >
                                                    {option.label}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>

                            <div className="flex flex-wrap items-center justify-between gap-4 border-t border-zinc-100 pt-6 dark:border-white/5">
                                <div className="flex flex-wrap items-center gap-3">
                                    <Button
                                        type="submit"
                                        className="rounded-xl bg-zinc-950 px-6 text-white hover:bg-zinc-800 dark:bg-emerald-600 dark:hover:bg-emerald-700"
                                    >
                                        Filter anwenden
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        onClick={resetFilters}
                                        className="rounded-xl border-zinc-200 dark:border-white/10"
                                    >
                                        <X className="mr-2 size-4" />
                                        Filter zurücksetzen
                                    </Button>
                                </div>
                                <span className="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                    {activeFilterCount === 0 ? 'Keine aktiven Filter' : `${activeFilterCount} aktive Filter`}
                                </span>
                            </div>
                        </form>
                    </section>
                </PageHeader>

                <DefaultContainer className="py-12">
                    {events.data.length === 0 ? (
                        <section className="rounded-[2rem] border border-dashed border-zinc-300 bg-zinc-50 px-6 py-12 text-center dark:border-white/15 dark:bg-white/5">
                            <Heading level={2}>Keine Veranstaltungen gefunden</Heading>
                            <p className="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                Passe die Filter an oder setze sie zurück, um weitere Termine zu sehen.
                            </p>
                        </section>
                    ) : (
                        <InfiniteScroll
                            data="events"
                            buffer={320}
                            loading={
                                <div className="py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Weitere Veranstaltungen werden geladen ...
                                </div>
                            }
                            next={({ manualMode, fetch, hasMore, loading }) => {
                                if (!hasMore || loading) {
                                    return null;
                                }

                                if (manualMode) {
                                    return (
                                        <div className="flex justify-center py-6">
                                            <Button
                                                type="button"
                                                variant="outline"
                                                onClick={fetch}
                                            >
                                                Weitere Veranstaltungen laden
                                            </Button>
                                        </div>
                                    );
                                }

                                return null;
                            }}
                        >
                            <div className="space-y-8">
                                {groupedEvents.map((group) => (
                                    <section
                                        key={group.key}
                                        className="space-y-3"
                                    >
                                        <div className="sticky top-16 z-10 -mx-4 px-4">
                                            <div className="inline-flex rounded-full border border-zinc-200 bg-white/90 px-4 py-2 text-sm font-medium shadow-sm backdrop-blur dark:border-white/10 dark:bg-zinc-950/90">
                                                {group.label}
                                            </div>
                                        </div>

                                        <div className="space-y-3">
                                            {group.events.map((event) => (
                                                <EventRow
                                                    key={event.id}
                                                    event={event}
                                                    currentUrl={page.url}
                                                />
                                            ))}
                                        </div>
                                    </section>
                                ))}
                            </div>
                        </InfiniteScroll>
                    )}
                </DefaultContainer>
            </div>
        </>
    );
};

EventsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default EventsIndex;
