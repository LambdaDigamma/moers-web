import { AutoDateRange } from '@/components/auto-timerange';
import { DateChip } from '@/components/date-chip';
import { Badge } from '@/components/ui/badge';
import { dayDifference } from '@/lib/date-format';
import { buildEventHref, getEventLocationLabel, getEventPrimaryLabel } from '@/lib/events';
import { Link } from '@inertiajs/react';
import { ChevronRight, Globe, MapPin } from 'lucide-react';
import React from 'react';
import Event = Modules.Events.Data.Event;

export const EventRow: React.FC<{ event: Event; currentUrl?: string; showParent?: boolean }> = ({ event, currentUrl, showParent = true }) => {
    const locationLabel = getEventLocationLabel(event);
    const primaryLabel = getEventPrimaryLabel(event);
    return (
        <article>
            <Link
                href={buildEventHref(event.id, currentUrl)}
                className="group hover:bg-muted focus-visible:outline-ring flex items-start gap-4 px-4 py-5 transition-colors focus-visible:outline-2 focus-visible:outline-offset-[-2px] sm:gap-5 sm:px-6"
            >
                <DateChip
                    date={event.showsDateComponent ? event.startDate : null}
                    isHighlighted={event.startDate !== null && dayDifference(event.startDate) === 0}
                />
                <div className="flex min-w-0 flex-1 flex-col gap-2">
                    <div className="flex flex-wrap items-center gap-2">
                        <h3 className="font-display tracking-title text-lg leading-snug font-semibold group-hover:underline">{event.name}</h3>
                        {primaryLabel && <Badge variant="secondary">{primaryLabel}</Badge>}
                    </div>
                    {showParent && event.parentEvent && <p className="text-muted-foreground text-xs">Teil von {event.parentEvent.name}</p>}
                    {event.excerpt && <p className="text-muted-foreground line-clamp-2 text-sm leading-6">{event.excerpt}</p>}
                    <div className="text-muted-foreground flex flex-wrap gap-x-4 gap-y-1 text-sm leading-5">
                        <span>
                            {event.showsDateComponent && event.startDate ? (
                                <AutoDateRange
                                    start={event.startDate}
                                    end={event.endDate}
                                    showTime={event.showsTimeComponent}
                                    isMultiDay={event.isMultiDay}
                                />
                            ) : (
                                'Termin wird noch bekanntgegeben'
                            )}
                        </span>
                        {locationLabel && (
                            <span className="flex items-center gap-1.5">
                                <MapPin className="size-3.5 shrink-0" />
                                {locationLabel}
                            </span>
                        )}
                        {event.organisationName && <span>{event.organisationName}</span>}
                        {event.isOnline && (
                            <span className="flex items-center gap-1.5">
                                <Globe className="size-3.5" />
                                Online verfügbar
                            </span>
                        )}
                    </div>
                </div>
                {event.headerImageUrl && (
                    <img
                        src={event.headerImageUrl}
                        alt=""
                        loading="lazy"
                        className="hidden h-24 w-32 shrink-0 rounded-lg object-cover lg:block"
                    />
                )}
                <ChevronRight className="text-muted-foreground mt-4 size-[18px] shrink-0 transition-transform group-hover:translate-x-0.5" />
            </Link>
        </article>
    );
};
