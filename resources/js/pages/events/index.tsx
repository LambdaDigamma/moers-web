import { DefaultContainer } from '@/components/default-container';
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

            <DefaultContainer className="pb-16">
                <div className="mt-8 space-y-8">
                    <section className="overflow-hidden rounded-[2rem] border border-zinc-200 bg-linear-to-br from-amber-50 via-white to-cyan-50 p-6 shadow-sm dark:border-white/10 dark:from-amber-500/10 dark:via-zinc-950 dark:to-cyan-500/10">
                        <div className="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                            <div className="max-w-3xl space-y-3">
                                <p className="text-sm font-medium tracking-[0.24em] text-zinc-500 uppercase dark:text-zinc-400">Terminkalender</p>
                                <Heading className="text-3xl sm:text-4xl">Veranstaltungen in Moers finden</Heading>
                                <p className="max-w-2xl text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                    Entdecke kommende Termine, sortiert nach Monaten und filterbar nach deinen Interessen.
                                </p>
                            </div>
                        </div>
                    </section>

                    <section className="rounded-[2rem] border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-zinc-950">
                        <form
                            className="space-y-4"
                            onSubmit={(event) => {
                                event.preventDefault();
                                applyFilters(values);
                            }}
                        >
                            <div className="grid gap-4 lg:grid-cols-[minmax(0,1.4fr)_repeat(4,minmax(0,1fr))]">
                                <div className="space-y-2">
                                    <Label htmlFor="event-search">Suche</Label>
                                    <div className="relative">
                                        <Search className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-zinc-400" />
                                        <Input
                                            id="event-search"
                                            type="search"
                                            value={values.search}
                                            onChange={(event) => setValues((current) => ({ ...current, search: event.target.value }))}
                                            placeholder="Titel, Stichwort oder Reihe"
                                            className="pl-9"
                                        />
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="event-type">Zeitraum</Label>
                                    <Select
                                        value={values.type || 'all'}
                                        onValueChange={(value) => updateFilter('type', value)}
                                    >
                                        <SelectTrigger id="event-type">
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
                                    <Label htmlFor="event-collection">Reihe</Label>
                                    <Select
                                        value={values.collection || 'all'}
                                        onValueChange={(value) => updateFilter('collection', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger id="event-collection">
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
                                    <Label htmlFor="event-organisation">Veranstalter</Label>
                                    <Select
                                        value={values.organisation || 'all'}
                                        onValueChange={(value) => updateFilter('organisation', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger id="event-organisation">
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
                                    <Label htmlFor="event-location">Ort</Label>
                                    <Select
                                        value={values.location || 'all'}
                                        onValueChange={(value) => updateFilter('location', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger id="event-location">
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

                            {availableFilters.categories.length > 0 ? (
                                <div className="space-y-2 lg:max-w-sm">
                                    <Label htmlFor="event-category">Kategorie</Label>
                                    <Select
                                        value={values.category || 'all'}
                                        onValueChange={(value) => updateFilter('category', value === 'all' ? '' : value)}
                                    >
                                        <SelectTrigger id="event-category">
                                            <SelectValue placeholder="Alle Kategorien" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Alle Kategorien</SelectItem>
                                            {availableFilters.categories.map((category) => (
                                                <SelectItem
                                                    key={category}
                                                    value={category}
                                                >
                                                    {category}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>
                            ) : null}

                            <div className="flex flex-wrap items-center gap-3">
                                <Button type="submit">Filter anwenden</Button>
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={resetFilters}
                                >
                                    <X className="size-4" />
                                    Filter zurücksetzen
                                </Button>
                                <span className="text-sm text-zinc-500 dark:text-zinc-400">
                                    {activeFilterCount === 0 ? 'Keine aktiven Filter' : `${activeFilterCount} aktive Filter`}
                                </span>
                            </div>
                        </form>
                    </section>

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
                </div>
            </DefaultContainer>
        </>
    );
};

EventsIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default EventsIndex;
