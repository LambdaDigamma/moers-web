import { formatTime } from '@/lib/date-format';
import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';

export type ParkingAreaSummary = {
    id: number;
    name: string;
    slug: string;
    capacity: number | null;
    occupied: number | null;
    state: string;
    updated_at: string | null;
};

const lowAvailabilityThreshold = 0.1;

const freeSpacesOf = (area: ParkingAreaSummary) => (area.capacity === null ? null : Math.max(0, area.capacity - (area.occupied ?? 0)));

const isAlmostFull = (area: ParkingAreaSummary) => {
    const freeSpaces = freeSpacesOf(area);

    return area.state === 'open' && area.capacity !== null && freeSpaces !== null && freeSpaces / area.capacity < lowAvailabilityThreshold;
};

const latestUpdateOf = (areas: ParkingAreaSummary[]) =>
    areas
        .map((area) => area.updated_at)
        .filter((value): value is string => value !== null)
        .sort()
        .at(-1) ?? null;

export function ParkingOverviewCard({ areas, totalSpaces, className }: { areas: ParkingAreaSummary[]; totalSpaces: number; className?: string }) {
    const latestUpdate = latestUpdateOf(areas);

    return (
        <section className={cn('border-border bg-card text-card-foreground flex flex-col overflow-hidden rounded-xl border', className)}>
            <header className="border-border flex items-center justify-between gap-4 border-b px-[22px] py-[18px]">
                <div className="flex flex-col gap-0.5">
                    <h3 className="font-display tracking-title text-lg leading-[22px] font-semibold">Parkhäuser live</h3>
                    <p className="text-muted-foreground text-[13px] leading-4">
                        {latestUpdate ? `Aktualisiert um ${formatTime(latestUpdate)} Uhr` : 'Aktuelle Belegung im Zentrum'}
                    </p>
                </div>
                <span className="font-display text-muted-foreground text-[15px] leading-[18px] font-semibold tabular-nums">
                    {totalSpaces.toLocaleString('de-DE')} Plätze
                </span>
            </header>

            {areas.length === 0 ? (
                <p className="text-muted-foreground px-[22px] py-6 text-sm">Aktuell liegen keine Parkdaten vor.</p>
            ) : (
                <ul className="divide-border divide-y">
                    {areas.map((area) => {
                        const isOpen = area.state === 'open';
                        const freeSpaces = freeSpacesOf(area);
                        const almostFull = isAlmostFull(area);
                        const occupancy = isOpen && area.capacity ? Math.min(100, Math.round(((area.occupied ?? 0) / area.capacity) * 100)) : 0;

                        return (
                            <li key={area.id}>
                                <Link
                                    href={route('parking-areas.show', [area.slug])}
                                    className="hover:bg-muted flex flex-col gap-2.5 px-[22px] py-3.5 transition-colors"
                                >
                                    <div className="flex items-center gap-2.5">
                                        <span
                                            className={cn(
                                                'size-2 shrink-0 rounded-full',
                                                !isOpen ? 'bg-graphit-300 dark:bg-graphit-600' : almostFull ? 'bg-warning' : 'bg-success',
                                            )}
                                        />
                                        <span className={cn('flex-1 text-[15px] leading-[18px] font-medium', !isOpen && 'text-muted-foreground')}>
                                            {area.name}
                                        </span>
                                        <span
                                            className={cn(
                                                'font-display text-lg leading-[22px] font-semibold tabular-nums',
                                                almostFull && 'text-warning',
                                                !isOpen && 'text-muted-foreground',
                                            )}
                                        >
                                            {isOpen && freeSpaces !== null ? freeSpaces : '–'}
                                        </span>
                                        <span className="text-muted-foreground w-7 shrink-0 text-[13px] leading-4">{isOpen ? 'frei' : 'zu'}</span>
                                    </div>
                                    <div className="bg-secondary h-1 overflow-hidden rounded-[2px]">
                                        <div
                                            className={cn('h-full rounded-[2px]', almostFull ? 'bg-warning' : 'bg-foreground')}
                                            style={{ width: `${occupancy}%` }}
                                        />
                                    </div>
                                </Link>
                            </li>
                        );
                    })}
                </ul>
            )}
        </section>
    );
}
