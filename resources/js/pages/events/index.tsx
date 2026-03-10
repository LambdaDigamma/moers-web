import { DefaultContainer } from '@/components/default-container';
import { IsolatedSearchField } from '@/components/isolated-search-field';
import { PageHeader } from '@/components/page-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Heading } from '@/components/ui/heading';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { formatCollectionLabel, getEventMonthGroupKey, getEventMonthGroupLabel } from '@/lib/events';
import { EventRow } from '@/pages/events/event-row';
import { type SharedData } from '@/types';
import { Head, InfiniteScroll, router, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { Filter, Search, SlidersHorizontal, X } from 'lucide-react';
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
        if (key === 'type') return availableFilters.types.find(t => t.value === value)?.label || value;
        if (key === 'organisation') return availableFilters.organisations.find(o => o.value === value)?.label || value;
        if (key === 'location') return availableFilters.locations.find(l => l.value === value)?.label || value;
        if (key === 'collection') return formatCollectionLabel(value) || value;
        return value;
    };

    return (
        <>
            <Head title="Veranstaltungen" />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <PageHeader
                    badge="Terminkalender"
                    title="Veranstaltungen in Moers"
                    description="Entdecke kommende Termine, sortiert nach Monaten und filterbar nach deinen Interessen."
                >
                    <div className="relative z-20 space-y-4">
                        <section className="overflow-hidden rounded-[2rem] border border-zinc-200 bg-white shadow-2xl shadow-zinc-200/50 dark:border-white/10 dark:bg-zinc-900 dark:shadow-none">
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
                                            className="h-14 border-none shadow-none ring-0 focus:ring-0 dark:bg-transparent"
                                        />
                                    </div>
                                    <div className="flex items-center gap-3 px-2">
                                        <Button
                                            type="button"
                                            variant={showFilters ? 'secondary' : 'outline'}
                                            onClick={() => setShowFilters(!showFilters)}
                                            className="h-12 rounded-2xl border-zinc-200 px-5 font-bold dark:border-white/10"
                                        >
                                            <SlidersHorizontal className="mr-2 size-4" />
                                            Filter
                                            {activeFilterCount > 0 && (
                                                <span className="ml-2 flex size-5 items-center justify-center rounded-full bg-accent-600 text-[10px] text-white">
                                                    {activeFilterCount}
                                                </span>
                                            )}
                                        </Button>
                                        <Button
                                            type="submit"
                                            className="h-12 rounded-2xl bg-zinc-950 px-8 font-bold text-white hover:bg-zinc-800 dark:bg-accent-600 dark:hover:bg-accent-700"
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
                                            className="overflow-hidden"
                                        >
                                            <div className="grid gap-6 border-t border-zinc-100 pt-8 mt-4 md:grid-cols-2 lg:grid-cols-4 dark:border-white/5">
                                                <div className="space-y-2">
                                                    <Label className="text-xs font-bold uppercase tracking-wider text-zinc-400">Zeitraum</Label>
                                                    <Select
                                                        value={values.type || 'all'}
                                                        onValueChange={(value) => updateFilter('type', value)}
                                                    >
                                                        <SelectTrigger className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950">
                                                            <SelectValue placeholder="Zeitraum wählen" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            {availableFilters.types.map((option) => (
                                                                <SelectItem key={option.value} value={option.value}>
                                                                    {option.label}
                                                                </SelectItem>
                                                            ))}
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label className="text-xs font-bold uppercase tracking-wider text-zinc-400">Reihe</Label>
                                                    <Select
                                                        value={values.collection || 'all'}
                                                        onValueChange={(value) => updateFilter('collection', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950">
                                                            <SelectValue placeholder="Alle Reihen" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectItem value="all">Alle Reihen</SelectItem>
                                                            {availableFilters.collections.map((collection) => (
                                                                <SelectItem key={collection} value={collection}>
                                                                    {formatCollectionLabel(collection) ?? collection}
                                                                </SelectItem>
                                                            ))}
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label className="text-xs font-bold uppercase tracking-wider text-zinc-400">Veranstalter</Label>
                                                    <Select
                                                        value={values.organisation || 'all'}
                                                        onValueChange={(value) => updateFilter('organisation', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950">
                                                            <SelectValue placeholder="Alle Veranstalter" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectItem value="all">Alle Veranstalter</SelectItem>
                                                            {availableFilters.organisations.map((option) => (
                                                                <SelectItem key={option.value} value={option.value}>
                                                                    {option.label}
                                                                </SelectItem>
                                                            ))}
                                                        </SelectContent>
                                                    </Select>
                                                </div>

                                                <div className="space-y-2">
                                                    <Label className="text-xs font-bold uppercase tracking-wider text-zinc-400">Ort</Label>
                                                    <Select
                                                        value={values.location || 'all'}
                                                        onValueChange={(value) => updateFilter('location', value === 'all' ? '' : value)}
                                                    >
                                                        <SelectTrigger className="h-11 rounded-xl border-zinc-200 bg-zinc-50 dark:border-white/10 dark:bg-zinc-950">
                                                            <SelectValue placeholder="Alle Orte" />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            <SelectItem value="all">Alle Orte</SelectItem>
                                                            {availableFilters.locations.map((option) => (
                                                                <SelectItem key={option.value} value={option.value}>
                                                                    {option.label}
                                                                </SelectItem>
                                                            ))}
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
                                    <span className="mr-2 text-xs font-bold uppercase tracking-widest text-zinc-400">Aktiv:</span>
                                    {activeFilters.map(([key, value]) => (
                                        <Badge
                                            key={key}
                                            variant="secondary"
                                            className="group h-7 rounded-full bg-accent-100 px-3 pr-1 text-xs font-medium text-accent-800 dark:bg-accent-900/30 dark:text-accent-300"
                                        >
                                            {getFilterLabel(key, value as string)}
                                            <button
                                                onClick={() => clearFilter(key as keyof EventFilters)}
                                                className="ml-2 flex h-5 w-5 items-center justify-center rounded-full hover:bg-accent-200 dark:hover:bg-accent-800"
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
                        <section className="rounded-[2.5rem] border border-dashed border-zinc-300 bg-white px-6 py-20 text-center dark:border-white/15 dark:bg-zinc-900/50">
                            <div className="mx-auto flex size-16 items-center justify-center rounded-full bg-zinc-100 dark:bg-white/5">
                                <Search className="size-8 text-zinc-400" />
                            </div>
                            <Heading level={2} className="mt-6">Keine Veranstaltungen gefunden</Heading>
                            <p className="mx-auto mt-3 max-w-sm text-sm leading-6 text-zinc-500 dark:text-zinc-400">
                                Wir konnten leider keine Termine für deine aktuelle Auswahl finden. Probiere es mit anderen Filtern.
                            </p>
                            <Button
                                onClick={resetFilters}
                                variant="outline"
                                className="mt-8 rounded-xl"
                            >
                                Suche zurücksetzen
                            </Button>
                        </section>
                    ) : (
                        <InfiniteScroll
                            data="events"
                            buffer={320}
                            loading={
                                <div className="py-12 text-center text-sm font-medium text-zinc-400 dark:text-zinc-500">
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
                                                className="rounded-xl px-10 font-bold"
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
                                            <div className="inline-flex rounded-full border border-zinc-200 bg-white/80 px-5 py-2 text-xs font-bold uppercase tracking-widest shadow-sm backdrop-blur-md dark:border-white/10 dark:bg-zinc-950/90">
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
