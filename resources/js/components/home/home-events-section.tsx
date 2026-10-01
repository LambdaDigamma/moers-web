import { DateChip } from '@/components/date-chip';
import { DefaultContainer } from '@/components/default-container';
import { ParkingOverviewCard } from '@/components/parking-overview-card';
import { PrimaryRubbishStreetCard } from '@/components/primary-rubbish-street-card';
import { SectionHeader } from '@/components/section-header';
import { dayDifference, formatDate, formatTime } from '@/lib/date-format';
import { cn } from '@/lib/utils';
import { type HomeEvent, type HomeEventDayFilter, type HomeParkingArea } from '@/types/home';
import { Link } from '@inertiajs/react';
import { ChevronRight } from 'lucide-react';

const scheduleLabelOf = (event: HomeEvent) => {
    if (event.showsTimeComponent && event.start_date) {
        return `${formatTime(event.start_date)} Uhr`;
    }

    if (event.showsDateComponent && event.start_date) {
        return formatDate(event.start_date, { dateStyle: 'medium' }) ?? 'Termin wird noch bekanntgegeben';
    }

    return 'Termin wird noch bekanntgegeben';
};

function EventRow({ event }: { event: HomeEvent }) {
    const isToday = event.start_date !== null && dayDifference(event.start_date) === 0;

    return (
        <li>
            <Link
                href={route('events.show', [event.id])}
                className="group hover:bg-muted flex items-center gap-5 px-5 py-[18px] transition-colors md:px-6"
            >
                <DateChip
                    date={event.showsDateComponent ? event.start_date : null}
                    isHighlighted={isToday}
                />
                <div className="flex min-w-0 flex-1 flex-col gap-1">
                    <span className="line-clamp-2 leading-5 font-semibold sm:line-clamp-1">{event.name}</span>
                    <span className="text-muted-foreground flex min-w-0 items-center gap-1.5 text-sm leading-[18px]">
                        <span className="shrink-0">{scheduleLabelOf(event)}</span>
                        {event.location && (
                            <>
                                <span aria-hidden="true">·</span>
                                <span className="truncate">{event.location}</span>
                            </>
                        )}
                    </span>
                </div>
                {event.category && (
                    <span className="bg-secondary text-graphit-700 dark:text-graphit-200 hidden max-w-40 shrink-0 truncate rounded-full px-2.5 py-1 text-xs leading-4 font-medium sm:inline-block">
                        {event.category}
                    </span>
                )}
                <ChevronRight className="text-graphit-400 size-[18px] shrink-0 transition-transform group-hover:translate-x-0.5" />
            </Link>
        </li>
    );
}

export function HomeEventsSection({
    events,
    dayFilters,
    selectedEventDay,
    parkingAreas,
    parkingSpaces,
}: {
    events: HomeEvent[];
    dayFilters: HomeEventDayFilter[];
    selectedEventDay: string;
    parkingAreas: HomeParkingArea[];
    parkingSpaces: number;
}) {
    return (
        <section className="bg-background">
            <DefaultContainer className="flex flex-col gap-8 pt-20 pb-20 md:pt-24 md:pb-[88px]">
                <SectionHeader
                    eyebrow="Diese Woche"
                    title="Was ist los in Moers?"
                    action={{ label: 'Alle Veranstaltungen', href: route('events.index') }}
                />

                <div className="grid grid-cols-1 items-start gap-10 lg:grid-cols-[minmax(0,1fr)_400px]">
                    <div className="flex flex-col gap-5">
                        <div
                            role="group"
                            aria-label="Nach Tag filtern"
                            className="flex flex-wrap gap-2"
                        >
                            {dayFilters.map((filter) => (
                                <Link
                                    key={filter.key}
                                    href={route('home', filter.key === 'all' ? {} : { event_day: filter.key })}
                                    only={['upcomingEvents', 'selectedEventDay']}
                                    preserveState
                                    preserveScroll
                                    aria-current={filter.key === selectedEventDay ? 'date' : undefined}
                                    className={cn(
                                        'focus-visible:outline-ring rounded-full border px-3.5 py-2 text-sm leading-[18px] transition-colors focus-visible:outline-2 focus-visible:outline-offset-2',
                                        filter.key === selectedEventDay
                                            ? 'border-primary bg-primary text-primary-foreground font-semibold'
                                            : 'border-border text-foreground hover:bg-accent font-medium',
                                    )}
                                >
                                    {filter.label}
                                </Link>
                            ))}
                        </div>

                        <div className="border-border bg-card overflow-hidden rounded-xl border">
                            {events.length === 0 ? (
                                <p className="text-muted-foreground px-6 py-12 text-center text-sm">
                                    {selectedEventDay === 'all'
                                        ? 'Aktuell sind keine Veranstaltungen eingetragen.'
                                        : 'An diesem Tag sind keine Veranstaltungen eingetragen.'}
                                </p>
                            ) : (
                                <ul className="divide-border divide-y">
                                    {events.map((event) => (
                                        <EventRow
                                            key={event.id}
                                            event={event}
                                        />
                                    ))}
                                </ul>
                            )}
                        </div>
                    </div>

                    <aside className="flex flex-col gap-5">
                        <PrimaryRubbishStreetCard />
                        <ParkingOverviewCard
                            areas={parkingAreas}
                            totalSpaces={parkingSpaces}
                        />
                    </aside>
                </div>
            </DefaultContainer>
        </section>
    );
}
