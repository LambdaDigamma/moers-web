import { AutoDateRange } from '@/components/auto-timerange';
import { Badge } from '@/components/ui/badge';
import { buildEventHref, getEventDateBadge, getEventLocationLabel, getEventPrimaryLabel } from '@/lib/events';
import { Link } from '@inertiajs/react';
import { CalendarDays, Globe, MapPin, UserRound } from 'lucide-react';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const EventRow: React.FC<{ event: Event; currentUrl?: string; showParent?: boolean }> = ({ event, currentUrl, showParent = true }) => {
    const dateBadge = getEventDateBadge(event);
    const locationLabel = getEventLocationLabel(event);
    const primaryLabel = getEventPrimaryLabel(event);

    return (
        <article className="group relative overflow-hidden rounded-3xl border border-zinc-200/80 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg dark:border-white/10 dark:bg-zinc-900">
            <div className="absolute inset-0 bg-linear-to-br from-amber-500/0 via-transparent to-cyan-500/0 opacity-0 transition group-hover:from-amber-500/6 group-hover:to-cyan-500/6 group-hover:opacity-100" />
            <div className="relative flex flex-col gap-4 md:flex-row md:items-start">
                <div className="flex flex-1 gap-4">
                    <div className="flex shrink-0 items-start">
                        <div className="min-w-18 rounded-2xl border border-zinc-200 bg-zinc-50 px-3 py-3 text-center dark:border-white/10 dark:bg-white/5">
                            {dateBadge ? (
                                <>
                                    <p className="text-[11px] font-medium tracking-[0.18em] text-zinc-500 uppercase dark:text-zinc-400">
                                        {dateBadge.weekday}
                                    </p>
                                    <p className="mt-1 text-3xl font-semibold text-zinc-950 dark:text-white">{dateBadge.day}</p>
                                    <p className="text-xs font-medium tracking-[0.16em] text-zinc-500 uppercase dark:text-zinc-400">
                                        {dateBadge.month}
                                    </p>
                                </>
                            ) : (
                                <div className="flex min-h-20 items-center justify-center text-xs font-medium tracking-[0.18em] text-zinc-500 uppercase dark:text-zinc-400">
                                    Termin
                                    <br />
                                    offen
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="min-w-0 flex-1 space-y-3">
                        <div className="flex flex-wrap gap-2">
                            {showParent && event.parentEvent && (
                                <Badge
                                    variant="outline"
                                    className="border-emerald-500/20 bg-emerald-500/10 text-emerald-700 dark:text-emerald-400"
                                >
                                    Teil von {event.parentEvent.name}
                                </Badge>
                            )}
                            {primaryLabel ? <Badge variant="secondary">{primaryLabel}</Badge> : null}
                            {event.organisationName ? <Badge variant="outline">{event.organisationName}</Badge> : null}
                            {event.isOnline ? <Badge variant="outline">Online</Badge> : null}
                        </div>

                        <div className="space-y-2">
                            <h3 className="text-lg font-semibold text-zinc-950 dark:text-white">{event.name}</h3>
                            <p className="line-clamp-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                {event.excerpt ?? 'Weitere Informationen folgen.'}
                            </p>
                        </div>

                        <div className="grid gap-2 text-sm text-zinc-600 sm:grid-cols-2 dark:text-zinc-300">
                            <div className="flex items-start gap-2">
                                <CalendarDays className="mt-0.5 size-4 shrink-0 text-zinc-400" />
                                <span>
                                    {event.startDate ? (
                                        <AutoDateRange
                                            start={event.startDate}
                                            end={event.endDate}
                                        />
                                    ) : (
                                        'Termin wird noch bekanntgegeben'
                                    )}
                                </span>
                            </div>

                            {locationLabel ? (
                                <div className="flex items-start gap-2">
                                    <MapPin className="mt-0.5 size-4 shrink-0 text-zinc-400" />
                                    <span>{locationLabel}</span>
                                </div>
                            ) : null}

                            {event.organisationName ? (
                                <div className="flex items-start gap-2">
                                    <UserRound className="mt-0.5 size-4 shrink-0 text-zinc-400" />
                                    <span>{event.organisationName}</span>
                                </div>
                            ) : null}

                            {event.isOnline ? (
                                <div className="flex items-start gap-2">
                                    <Globe className="mt-0.5 size-4 shrink-0 text-zinc-400" />
                                    <span>Online verfügbar</span>
                                </div>
                            ) : null}
                        </div>
                    </div>
                </div>

                {event.headerImageUrl ? (
                    <div className="overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-100 md:w-44 dark:border-white/10 dark:bg-white/5">
                        <img
                            src={event.headerImageUrl}
                            alt={event.name}
                            className="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                        />
                    </div>
                ) : null}
            </div>

            <Link
                href={buildEventHref(event.id, currentUrl)}
                className="absolute inset-0"
            >
                <span className="sr-only">Details zu {event.name}</span>
            </Link>
        </article>
    );
};
