import { DefaultContainer } from '@/components/default-container';
import { IsolatedSearchField } from '@/components/isolated-search-field';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { formatCollectionLabel, getEventMonthGroupKey, getEventMonthGroupLabel } from '@/lib/events';
import { EventRow } from '@/pages/events/event-row';
import { type SharedData } from '@/types';
import { InfiniteScroll, router, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { Search, SlidersHorizontal, X } from 'lucide-react';
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
    const [showFilters, setShowFilters] = useState(false);

    useEffect(() => {
        setValues(filters);
    }, [filters]);

    const groupedEvents = groupEvents(events.data);

    const activeFilters = Object.entries(values).filter(([key, value]) => {
        if (key === 'type') return value !== '' && value !== 'upcoming';
        return value !== '' && key !== 'search';
    });

    const activeFilterCount = activeFilters.length;

    const applyFilters = (nextValues: EventFilters) => {
        router.get(route('events.index'), normalizeFilters(nextValues), {
            preserveState: true,
            preserveScroll: true,
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

    const clearFilter = (key: keyof EventFilters) => {
        const nextValues = {
            ...values,
            [key]: key === 'type' ? 'upcoming' : '',
        };
        setValues(nextValues);
        applyFilters(nextValues);
    };

    const getFilterLabel = (key: string, value: string) => {
        if (key === 'type') return availableFilters.types.find((t) => t.value === value)?.label || value;
        if (key === 'organisation') return availableFilters.organisations.find((o) => o.value === value)?.label || value;
        if (key === 'location') return availableFilters.locations.find((l) => l.value === value)?.label || value;
        if (key === 'collection') return formatCollectionLabel(value) || value;
        return value;
    };

    return (
        <>
            <SeoHead
                title="Veranstaltungen in Moers"
                description="Entdecke kommende Veranstaltungen in Moers: Kultur, Musik, Sport und weitere Termine übersichtlich nach deinen Interessen."
            />

            <div className="bg-background min-h-screen">
                <PageHeader
                    badge="Terminkalender"
                    title="Veranstaltungen in Moers"
                    description="Entdecke kommende Termine, sortiert nach Monaten und filterbar nach deinen Interessen."
                >
                    <div className="relative z-20 space-y-4">
                        <section className="border-border bg-card overflow-hidden rounded-xl border">
                            <div className="p-4 md:p-6">
                                <form
                                    className="flex flex-col gap-4 md:flex-row md:items-center"
                                    onSubmit={(event) => {
                                        event.preventDefault();
                                        applyFilters(values);
                                    }}
                                >
                                    <div className="relative flex-1">
                                        <IsolatedSearchField
                                            value={values.search}
                                            onChange={(event) => setValues((current) => ({ ...current, search: event.target.value }))}
                                            placeholder="Nach Veranstaltungen suchen..."
                                            aria-label="Veranstaltungen suchen"
                                        />
                                    </div>
                                    <div className="flex items-center gap-3 px-2">
                                        <Button
                                            type="button"
                                            variant={showFilters ? 'secondary' : 'outline'}
                                            onClick={() => setShowFilters(!showFilters)}
                                            aria-expanded={showFilters}
                                            aria-controls="event-filters"
                                            className="h-12 px-5"
                                        >
                                            <SlidersHorizontal data-icon="inline-start" />
                                            Filter
                                            {activeFilterCount > 0 && <Badge variant="secondary">{activeFilterCount}</Badge>}
                                        </Button>
                                        <Button
                                            type="submit"
                                            className="h-12 px-6"
                                        >
                                            Suchen
                                        </Button>
                                    </div>
                                </form>

                                <AnimatePresence>
                                    {showFilters && (
                                        <motion.div
                                            initial={{ height: 0, opacity: 0 }}
                                            animate={{ height: 'auto', opacity: 1 }}
                                            exit={{ height: 0, opacity: 0 }}
                                            transition={{ duration: 0.3, ease: 'easeInOut' }}
                                            id="event-filters"
                                            className="overflow-hidden"
                                        >
                                            <div className="border-border mt-6 grid gap-6 border-t pt-6 md:grid-cols-2 lg:grid-cols-4">
                                                <div className="space-y-2">
                                                    <Label
                                                        htmlFor="event-period"
                                                        className="text-muted-foreground text-xs font-semibold"
                                                    >
                                                        Zeitraum
                                                    </Label>
                                                    <Select
                                                        value={values.type || 'all'}
                                                        onValueChange={(value) => updateFilter('type', value)}
                                                    >
                                                        <SelectTrigger
                                                            id="event-period"
                                                            className="h-11"
                                                        >
                                                            <SelectValue placeholder="Zeitraum wählen" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectGroup>
                                                                {availableFilters.types.map((option) => (
                                                                    <SelectItem
                                                                        key={option.value}
                                                                        value={option.value}
                                                                    >
                                                                        {option.label}
                                                                    </SelectItem>
                                                                ))}
                                                            </SelectGroup>
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label
                                                        htmlFor="event-collection"
                                                        className="text-muted-foreground text-xs font-semibold"
                                                    >
                                                        Reihe
                                                    </Label>
                                                    <Select
                                                        value={values.collection || 'all'}
                                                        onValueChange={(value) => updateFilter('collection', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger
                                                            id="event-collection"
                                                            className="h-11"
                                                        >
                                                            <SelectValue placeholder="Alle Reihen" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectGroup>
                                                                <SelectItem value="all">Alle Reihen</SelectItem>
                                                                {availableFilters.collections.map((collection) => (
                                                                    <SelectItem
                                                                        key={collection}
                                                                        value={collection}
                                                                    >
                                                                        {formatCollectionLabel(collection) ?? collection}
                                                                    </SelectItem>
                                                                ))}
                                                            </SelectGroup>
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label
                                                        htmlFor="event-organisation"
                                                        className="text-muted-foreground text-xs font-semibold"
                                                    >
                                                        Veranstalter
                                                    </Label>
                                                    <Select
                                                        value={values.organisation || 'all'}
                                                        onValueChange={(value) => updateFilter('organisation', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger
                                                            id="event-organisation"
                                                            className="h-11"
                                                        >
                                                            <SelectValue placeholder="Alle Veranstalter" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectGroup>
                                                                <SelectItem value="all">Alle Veranstalter</SelectItem>
                                                                {availableFilters.organisations.map((option) => (
                                                                    <SelectItem
                                                                        key={option.value}
                                                                        value={option.value}
                                                                    >
                                                                        {option.label}
                                                                    </SelectItem>
                                                                ))}
                                                            </SelectGroup>
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label
                                                        htmlFor="event-location"
                                                        className="text-muted-foreground text-xs font-semibold"
                                                    >
                                                        Ort
                                                    </Label>
                                                    <Select
                                                        value={values.location || 'all'}
                                                        onValueChange={(value) => updateFilter('location', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger
                                                            id="event-location"
                                                            className="h-11"
                                                        >
                                                            <SelectValue placeholder="Alle Orte" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectGroup>
                                                                <SelectItem value="all">Alle Orte</SelectItem>
                                                                {availableFilters.locations.map((option) => (
                                                                    <SelectItem
                                                                        key={option.value}
                                                                        value={option.value}
                                                                    >
                                                                        {option.label}
                                                                    </SelectItem>
                                                                ))}
                                                            </SelectGroup>
                                                        </SelectContent>
                                                    </Select>
                                                </div>
                                            </div>
                                            <div className="mt-6 flex justify-end">
                                                <Button
                                                    type="button"
                                                    variant="ghost"
                                                    size="sm"
                                                    onClick={resetFilters}
                                                    className="text-zinc-500 hover:text-red-600"
                                                >
                                                    <X className="mr-2 size-4" />
                                                    Alle Filter zurücksetzen
                                                </Button>
                                            </div>
                                        </motion.div>
                                    )}
                                </AnimatePresence>
                            </div>
                        </section>

                        {/* Active Filter Tags */}
                        <AnimatePresence>
                            {activeFilterCount > 0 && (
                                <motion.div
                                    initial={{ opacity: 0, y: -10 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    exit={{ opacity: 0, y: -10 }}
                                    className="flex flex-wrap items-center gap-2 px-4"
                                >
                                    <span className="mr-2 text-xs font-semibold tracking-widest text-zinc-400 uppercase">Aktiv:</span>
                                    {activeFilters.map(([key, value]) => (
                                        <Badge
                                            key={key}
                                            variant="secondary"
                                            className="group h-7 gap-2 px-3 pr-1"
                                        >
                                            {getFilterLabel(key, value as string)}
                                            <button
                                                onClick={() => clearFilter(key as keyof EventFilters)}
                                                aria-label={`${getFilterLabel(key, value as string)} entfernen`}
                                                className="hover:bg-muted focus-visible:outline-ring flex size-5 items-center justify-center rounded-full focus-visible:outline-2"
                                            >
                                                <X className="size-3" />
                                            </button>
                                        </Badge>
                                    ))}
                                </motion.div>
                            )}
                        </AnimatePresence>
                    </div>
                </PageHeader>

                <DefaultContainer className="py-12">
                    {events.data.length === 0 ? (
                        <Empty className="border-border bg-muted rounded-xl border">
                            <EmptyHeader>
                                <EmptyMedia variant="icon">
                                    <Search />
                                </EmptyMedia>
                                <EmptyTitle>Keine Veranstaltungen gefunden</EmptyTitle>
                                <EmptyDescription>
                                    Wir konnten leider keine Termine für deine aktuelle Auswahl finden. Probiere es mit anderen Filtern.
                                </EmptyDescription>
                            </EmptyHeader>
                            <EmptyContent>
                                <Button
                                    onClick={resetFilters}
                                    variant="outline"
                                >
                                    Suche zurücksetzen
                                </Button>
                            </EmptyContent>
                        </Empty>
                    ) : (
                        <InfiniteScroll
                            data="events"
                            buffer={320}
                            loading={
                                <div className="text-muted-foreground py-12 text-center text-sm font-medium">
                                    Weitere Veranstaltungen werden geladen ...
                                </div>
                            }
                            next={({ manualMode, fetch, hasMore, loading }) => {
                                if (!hasMore || loading) {
                                    return null;
                                }

                                if (manualMode) {
                                    return (
                                        <div className="flex justify-center py-12">
                                            <Button
                                                type="button"
                                                variant="outline"
                                                className="rounded-xl px-10 font-semibold"
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
                            <div className="space-y-12">
                                {groupedEvents.map((group) => (
                                    <section
                                        key={group.key}
                                        className="space-y-4"
                                    >
                                        <div className="sticky top-[4.5rem] z-10 -mx-4 px-4 py-2">
                                            <h2 className="font-display tracking-heading bg-background py-2 text-2xl font-semibold">{group.label}</h2>
                                        </div>

                                        <div className="divide-border border-border bg-card divide-y overflow-hidden rounded-xl border">
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
