import { DefaultContainer } from '@/components/default-container';
import { HeroStatCard } from '@/components/hero-stat-card';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import { rubbishPickupMeta, useRubbishPickups } from '@/hooks/use-rubbish-pickups';
import { formatDate, formatRelativeDay, formatTime } from '@/lib/date-format';
import { type HomeParkingArea, type HomeStats } from '@/types/home';
import { Link } from '@inertiajs/react';
import { CalendarRange, CircleParking, Search, Trash2 } from 'lucide-react';

const popularLinks = (featuredParkingArea: HomeParkingArea | undefined): { label: string; href: string }[] => [
    { label: 'Abfuhrtermine', href: route('rubbish.index') },
    { label: 'Moers Festival', href: route('events.index', { search: 'Moers Festival' }) },
    { label: 'Wochenmarkt', href: route('events.index', { search: 'Wochenmarkt' }) },
    featuredParkingArea
        ? { label: `Parkhaus ${featuredParkingArea.name}`, href: route('parking-areas.show', [featuredParkingArea.slug]) }
        : { label: 'Parkhäuser', href: route('parking-areas.index') },
];

const featuredParkingAreaOf = (parkingAreas: HomeParkingArea[]) => parkingAreas.find((area) => area.state === 'open' && area.capacity !== null);

function WasteStatCard() {
    const { primaryStreet, isLoaded } = usePrimaryRubbishStreet();
    const { pickups, isLoading } = useRubbishPickups(primaryStreet?.id ?? null, 1);
    const [nextPickup] = pickups;

    if (isLoaded && !primaryStreet) {
        return (
            <HeroStatCard
                icon={Trash2}
                label="Abfallkalender"
                value="Straße wählen"
                caption="und keine Abholung mehr verpassen"
                href={route('rubbish.index')}
            />
        );
    }

    return (
        <HeroStatCard
            icon={Trash2}
            label={primaryStreet ? `Abfall · ${primaryStreet.name}` : 'Abfallkalender'}
            value={nextPickup ? formatRelativeDay(nextPickup.date) : 'Keine Termine'}
            caption={
                nextPickup
                    ? `${rubbishPickupMeta[nextPickup.type].label} · ${formatDate(nextPickup.date, { weekday: 'long', day: 'numeric', month: 'long' })}`
                    : 'Aktuell sind keine Abholungen geplant'
            }
            href={primaryStreet ? route('rubbish.show', [primaryStreet.id]) : route('rubbish.index')}
            isLoading={!isLoaded || isLoading}
        />
    );
}

function ParkingStatCard({ parkingAreas }: { parkingAreas: HomeParkingArea[] }) {
    const featuredArea = featuredParkingAreaOf(parkingAreas);

    if (!featuredArea || featuredArea.capacity === null) {
        return (
            <HeroStatCard
                icon={CircleParking}
                label="Parkhäuser · Live"
                value="Parken"
                caption="Belegung der Parkhäuser in der Innenstadt"
                href={route('parking-areas.index')}
            />
        );
    }

    const freeSpaces = Math.max(0, featuredArea.capacity - (featuredArea.occupied ?? 0));
    const updatedAt = featuredArea.updated_at ? ` · aktualisiert ${formatTime(featuredArea.updated_at)}` : '';

    return (
        <HeroStatCard
            icon={CircleParking}
            label={`Parkhaus ${featuredArea.name} · Live`}
            value={`${freeSpaces} frei`}
            caption={`von ${featuredArea.capacity} Plätzen${updatedAt}`}
            href={route('parking-areas.show', [featuredArea.slug])}
        />
    );
}

export function HomeHero({ stats, parkingAreas }: { stats: HomeStats; parkingAreas: HomeParkingArea[] }) {
    const hasEventsSoon = stats.events_today_and_tomorrow > 0;

    return (
        <section className="bg-hero-glow text-hero-foreground relative overflow-hidden pt-[72px]">
            <DefaultContainer className="flex flex-col items-center gap-7 pt-20 pb-14 text-center md:pt-28">
                <div className="border-hero-border inline-flex items-center gap-2.5 rounded-full border bg-white/4 py-1.5 pr-3.5 pl-3">
                    <span className="bg-accent-500 size-1.5 rounded-full" />
                    <span className="text-hero-muted text-[13px] leading-4 font-medium">
                        {formatDate(new Date().toISOString(), { weekday: 'long', day: 'numeric', month: 'long' })}
                    </span>
                </div>

                <h1 className="font-display tracking-display max-w-[900px] text-5xl leading-[1.05] font-semibold sm:text-6xl md:text-[84px] md:leading-[88px]">
                    Was ist heute los <br className="hidden md:inline" />
                    in Moers?
                </h1>

                <p className="text-hero-muted max-w-[600px] text-lg leading-relaxed md:text-[19px] md:leading-[30px]">
                    Termine, Nachrichten, Abfallkalender und freie Parkplätze – an einem Ort und ohne Anmeldung nutzbar.
                </p>

                <form
                    action={route('events.index')}
                    method="get"
                    role="search"
                    className="bg-hero-foreground flex h-16 w-full max-w-[720px] items-center gap-3.5 rounded-2xl pr-2 pl-[22px] text-left shadow-[0_0_0_6px_rgb(255_255_255/0.06),0_12px_32px_rgb(0_0_0/0.3)]"
                >
                    <Search
                        className="text-graphit-600 size-[22px] shrink-0"
                        strokeWidth={2}
                    />
                    <label
                        htmlFor="home-search"
                        className="sr-only"
                    >
                        Veranstaltungen in Moers suchen
                    </label>
                    <input
                        id="home-search"
                        name="search"
                        type="search"
                        placeholder="Veranstaltung suchen …"
                        className="text-graphit-900 placeholder:text-graphit-600 h-full min-w-0 flex-1 bg-transparent text-base leading-[22px] outline-none md:text-[17px]"
                    />
                    <button
                        type="submit"
                        className="bg-graphit-900 hover:bg-graphit-800 focus-visible:outline-ring flex h-12 shrink-0 items-center rounded-lg px-[22px] text-[15px] leading-[18px] font-semibold text-white transition-colors focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        Suchen
                    </button>
                </form>

                <nav
                    aria-label="Beliebte Bereiche"
                    className="flex flex-wrap items-center justify-center gap-2 text-sm leading-[18px]"
                >
                    <span className="text-hero-subtle">Beliebt:</span>
                    {popularLinks(featuredParkingAreaOf(parkingAreas)).map((link) => (
                        <Link
                            key={link.label}
                            href={link.href}
                            className="border-hero-border text-hero-muted hover:bg-hero-surface hover:text-hero-foreground rounded-full border px-3 py-[5px] transition-colors"
                        >
                            {link.label}
                        </Link>
                    ))}
                </nav>
            </DefaultContainer>

            <DefaultContainer className="grid grid-cols-1 gap-4 pt-10 pb-16 md:grid-cols-3 md:pb-20">
                <WasteStatCard />
                <ParkingStatCard parkingAreas={parkingAreas} />
                <HeroStatCard
                    icon={CalendarRange}
                    label="Veranstaltungen"
                    value={`${hasEventsSoon ? stats.events_today_and_tomorrow : stats.upcoming_events} Termine`}
                    caption={hasEventsSoon ? 'heute und morgen in Moers' : 'demnächst in Moers'}
                    href={route('events.index')}
                />
            </DefaultContainer>
        </section>
    );
}
