import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import { rubbishPickupMeta, useRubbishPickups } from '@/hooks/use-rubbish-pickups';
import { dayDifference, formatDate, formatRelativeDay, formatShortDate } from '@/lib/date-format';
import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { CalendarDays, ChevronRight, MapPinned } from 'lucide-react';

export function PrimaryRubbishStreetCard({ className }: { className?: string }) {
    const { primaryStreet, isLoaded } = usePrimaryRubbishStreet();
    const { pickups, isLoading } = useRubbishPickups(primaryStreet?.id ?? null);
    const [nextPickup, ...laterPickups] = pickups;

    return (
        <section className={cn('border-border bg-card text-card-foreground flex flex-col overflow-hidden rounded-xl border', className)}>
            <header className="border-border flex items-center justify-between gap-4 border-b px-[22px] py-[18px]">
                <div className="flex min-w-0 flex-col gap-0.5">
                    <h3 className="font-display tracking-title text-lg leading-[22px] font-semibold">Meine Straße</h3>
                    {primaryStreet ? (
                        <p className="text-muted-foreground truncate text-[13px] leading-4">
                            {primaryStreet.name}
                            {primaryStreet.street_addition && ` (${primaryStreet.street_addition})`}
                            {' · '}
                            <Link
                                href={route('rubbish.index')}
                                className="hover:text-foreground underline-offset-4 hover:underline"
                            >
                                ändern
                            </Link>
                        </p>
                    ) : (
                        <p className="text-muted-foreground text-[13px] leading-4">Lokale Auswahl für deinen Abfallkalender</p>
                    )}
                </div>
                {primaryStreet && (
                    <Link
                        href={route('rubbish.show', [primaryStreet.id])}
                        className="border-border text-foreground hover:bg-accent flex size-9 shrink-0 items-center justify-center rounded-md border transition-colors"
                    >
                        <CalendarDays
                            className="size-[18px]"
                            strokeWidth={1.75}
                        />
                        <span className="sr-only">Alle Abholtermine ansehen</span>
                    </Link>
                )}
            </header>

            {!isLoaded || isLoading ? (
                <div className="divide-border divide-y">
                    {[0, 1, 2].map((index) => (
                        <div
                            key={index}
                            className="bg-muted/60 h-[47px] animate-pulse"
                        />
                    ))}
                </div>
            ) : !primaryStreet ? (
                <div className="flex flex-col gap-4 p-[22px]">
                    <div className="border-border bg-muted flex items-start gap-3 rounded-lg border border-dashed p-4">
                        <MapPinned className="text-muted-foreground mt-0.5 size-4 shrink-0" />
                        <div className="min-w-0">
                            <p className="text-sm font-semibold">Keine Straße gewählt</p>
                            <p className="text-muted-foreground mt-1 text-[13px] leading-relaxed">
                                Wähle deine Straße, um die nächsten Abholtermine zu sehen.
                            </p>
                        </div>
                    </div>
                    <Link
                        href={route('rubbish.index')}
                        className="text-foreground inline-flex items-center gap-1 text-sm font-semibold"
                    >
                        Straße auswählen
                        <ChevronRight className="size-4" />
                    </Link>
                </div>
            ) : !nextPickup ? (
                <p className="text-muted-foreground px-[22px] py-6 text-sm">Keine kommenden Abholtermine gefunden.</p>
            ) : (
                <ul className="divide-border divide-y">
                    <li className="bg-muted flex items-center gap-3.5 px-[22px] py-[18px]">
                        <span className={cn('size-2.5 shrink-0 rounded-full', rubbishPickupMeta[nextPickup.type].dotClassName)} />
                        <div className="flex min-w-0 flex-1 flex-col gap-0.5">
                            <span className="leading-5 font-semibold">{rubbishPickupMeta[nextPickup.type].label}</span>
                            <span className="text-muted-foreground text-[13px] leading-4">
                                {formatDate(nextPickup.date, { weekday: 'long', day: 'numeric', month: 'long' })}
                            </span>
                        </div>
                        {dayDifference(nextPickup.date) <= 1 && (
                            <span className="bg-accent-100 text-accent-800 dark:bg-accent-500/15 dark:text-accent-300 shrink-0 rounded-full px-2.5 py-1 text-xs leading-4 font-semibold">
                                {formatRelativeDay(nextPickup.date)}
                            </span>
                        )}
                    </li>
                    {laterPickups.map((pickup, index) => (
                        <li
                            key={`${pickup.date}-${pickup.type}-${index}`}
                            className="flex items-center gap-3.5 px-[22px] py-3.5"
                        >
                            <span className={cn('size-2.5 shrink-0 rounded-full', rubbishPickupMeta[pickup.type].dotClassName)} />
                            <span className="flex-1 text-[15px] leading-[18px] font-medium">{rubbishPickupMeta[pickup.type].label}</span>
                            <span className="text-muted-foreground text-sm leading-[18px] tabular-nums">{formatShortDate(pickup.date)}</span>
                        </li>
                    ))}
                </ul>
            )}
        </section>
    );
}
