import { DefaultContainer } from '@/components/default-container';
import { PrimaryRubbishStreetCard } from '@/components/primary-rubbish-street-card';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight, CalendarRange, CircleParking, Leaf, MapPin, Newspaper, Radio, Search, Smartphone, Star } from 'lucide-react';
import { ReactNode } from 'react';

type HomeProps = {
    stats: {
        upcoming_events: number;
        news_posts: number;
        rubbish_streets: number;
        parking_spaces: number;
    };
    upcomingEvents: {
        id: number;
        name: string;
        start_date: string | null;
        scheduleDisplay: string;
        showsDateComponent: boolean;
        showsTimeComponent: boolean;
        location: string | null;
    }[];
    latestNews: {
        id: number;
        title: string;
        summary: string | null;
        published_at: string | null;
        external_href: string | null;
        source_name: string | null;
        header_image_url: string | null;
    }[];
    parkingAreas: {
        id: number;
        name: string;
        capacity: number | null;
        occupied: number | null;
        state: string;
    }[];
    mobileApps: {
        ios_url: string;
        android_url: string;
    };
};

const formatDate = (value: string | null, options: Intl.DateTimeFormatOptions) => {
    if (!value) {
        return null;
    }

    return new Intl.DateTimeFormat('de-DE', options).format(new Date(value));
};

const MobileAppBadge = ({ href, platform }: { href: string; platform: 'ios' | 'android' }) => (
    <a
        href={href}
        target="_blank"
        rel="noreferrer"
        className="inline-block transition hover:opacity-80 active:scale-95"
    >
        {platform === 'ios' ? (
            <img
                src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/de-de?size=250x83"
                alt="Download on the App Store"
                className="h-10 w-auto"
            />
        ) : (
            <img
                src="https://play.google.com/intl/en_us/badges/static/images/badges/de_badge_web_generic.png"
                alt="Get it on Google Play"
                className="-my-2 h-14 w-auto"
            />
        )}
    </a>
);

function Home({ stats, upcomingEvents, latestNews, parkingAreas, mobileApps }: HomeProps) {
    return (
        <>
            <Head title="Mein Moers" />

            <div className="relative overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(238,242,255,0.8),_transparent_40%),radial-gradient(circle_at_top_right,_rgba(209,250,229,0.7),_transparent_40%),linear-gradient(180deg,_#fbfbf9_0%,_#ffffff_100%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.1),_transparent_40%),radial-gradient(circle_at_top_right,_rgba(16,185,129,0.1),_transparent_40%),linear-gradient(180deg,_#09090b_0%,_#111827_100%)]">
                <DefaultContainer className="py-8 md:py-16 lg:py-24">
                    <div className="grid items-center gap-12 lg:grid-cols-2">
                        <section className="space-y-6 md:space-y-8">
                            <div className="inline-flex items-center rounded-full border border-accent-200/60 bg-white/50 px-3 py-1 text-xs font-medium tracking-wide text-accent-800 shadow-xs backdrop-blur-sm dark:border-accent-500/20 dark:bg-white/5 dark:text-accent-300">
                                <Star className="mr-2 size-3 fill-current" />
                                Alles für Moers in einer App
                            </div>

                            <div className="space-y-4 md:space-y-6">
                                <h1 className="text-4xl leading-[1.1] font-bold tracking-tight text-zinc-950 md:text-5xl lg:text-6xl dark:text-white">
                                    Moers – digital, <br />
                                    einfach und direkt.
                                </h1>
                                <p className="max-w-xl text-base leading-relaxed text-zinc-600 md:text-lg dark:text-zinc-400">
                                    Aktuelle Nachrichten, Veranstaltungen und der Abfallkalender für deine Straße. Alles an einem Ort, auch ohne Login
                                    nutzbar.
                                </p>
                            </div>

                            <div className="relative max-w-xl">
                                <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <Search className="size-5 text-zinc-400" />
                                </div>
                                <input
                                    type="text"
                                    className="h-12 w-full rounded-xl border-0 bg-white px-12 text-base shadow-xs ring-1 ring-zinc-200 focus:ring-2 focus:ring-accent-500 dark:bg-zinc-900 dark:ring-white/10"
                                    placeholder="Suchen in Moers..."
                                    disabled
                                />
                                <div className="absolute inset-y-0 right-2 flex items-center">
                                    <span className="hidden rounded-lg bg-zinc-50 px-2 py-1 text-xs font-medium text-zinc-400 sm:inline-block dark:bg-white/5">
                                        Bald verfügbar
                                    </span>
                                </div>
                            </div>

                            <div className="flex flex-wrap items-center gap-6 pt-2">
                                <div className="flex flex-wrap items-center gap-3">
                                    <MobileAppBadge
                                        href={mobileApps.ios_url}
                                        platform="ios"
                                    />
                                    <MobileAppBadge
                                        href={mobileApps.android_url}
                                        platform="android"
                                    />
                                </div>
                                <div className="hidden h-8 w-px bg-zinc-200 sm:block dark:bg-white/10" />
                                <Link
                                    href={route('events.index')}
                                    className="text-sm font-medium text-accent-600 transition hover:text-accent-700 dark:text-accent-400 dark:hover:text-accent-300"
                                >
                                    Web-Version nutzen <ArrowRight className="ml-1 inline size-4" />
                                </Link>
                            </div>
                        </section>

                        <div className="relative hidden lg:block">
                            <div className="absolute -top-12 -right-12 size-96 rounded-full bg-accent-500/10 blur-3xl" />
                            <div className="absolute -bottom-12 -left-12 size-96 rounded-full bg-accent-500/10 blur-3xl" />

                            <div className="relative flex justify-center">
                                {/* Main Phone Mockup */}
                                <div className="relative z-10 h-[500px] w-64 rotate-2 rounded-[2.5rem] border-[8px] border-zinc-900 bg-zinc-950 shadow-2xl ring-1 ring-white/10">
                                    <div className="absolute top-0 left-1/2 h-6 w-24 -translate-x-1/2 rounded-b-2xl bg-zinc-900" />
                                    <div className="h-full overflow-hidden rounded-[2rem] bg-zinc-100 p-4 dark:bg-zinc-900">
                                        <div className="mt-8 space-y-4">
                                            <div className="h-4 w-20 rounded-full bg-accent-500/20" />
                                            <div className="h-24 rounded-2xl bg-white shadow-sm dark:bg-white/5" />
                                            <div className="h-32 rounded-2xl bg-white shadow-sm dark:bg-white/5" />
                                            <div className="h-24 rounded-2xl bg-white shadow-sm dark:bg-white/5" />
                                        </div>
                                    </div>
                                </div>

                                {/* Background Phone Mockup */}
                                <div className="absolute top-12 -left-12 h-[460px] w-60 -rotate-6 rounded-[2.5rem] border-[8px] border-zinc-900/50 bg-zinc-950/50 shadow-xl blur-[1px]">
                                    <div className="h-full overflow-hidden rounded-[2rem] bg-zinc-100/50 p-4 dark:bg-zinc-900/50" />
                                </div>
                            </div>
                        </div>
                    </div>
                </DefaultContainer>
            </div>

            <DefaultContainer className="space-y-12 py-12 md:py-20">
                {/* Featured Content Grid */}
                <div className="grid gap-8 lg:grid-cols-[1fr_380px]">
                    <div className="space-y-8">
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-xs dark:border-white/10">
                            <CardHeader className="border-b border-zinc-100 py-5 dark:border-white/5">
                                <div className="flex items-center justify-between gap-4">
                                    <div>
                                        <CardTitle className="flex items-center gap-2.5 text-xl font-bold">
                                            <CalendarRange className="size-5 text-accent-600" />
                                            Veranstaltungen
                                        </CardTitle>
                                        <CardDescription className="text-sm">Was ist los in unserer Stadt?</CardDescription>
                                    </div>
                                    <Button
                                        asChild
                                        variant="secondary"
                                        size="sm"
                                        className="h-8 rounded-full text-xs"
                                    >
                                        <Link href={route('events.index')}>Alle Termine</Link>
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent className="p-0">
                                {upcomingEvents.length === 0 ? (
                                    <div className="px-6 py-10 text-center text-sm text-zinc-500">
                                        Aktuell sind keine Veranstaltungen eingetragen.
                                    </div>
                                ) : (
                                    <ul className="divide-y divide-zinc-100 dark:divide-white/5">
                                        {upcomingEvents.map((event) => (
                                            <li key={event.id}>
                                                <Link
                                                    href={route('events.show', [event.id])}
                                                    className="group flex items-center justify-between gap-6 px-6 py-4 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                                >
                                                    <div className="flex items-center gap-4">
                                                        <div className="flex size-12 flex-col items-center justify-center rounded-xl bg-zinc-100 transition-colors group-hover:bg-accent-50 dark:bg-white/5 dark:group-hover:bg-accent-500/10">
                                                            {event.showsDateComponent && event.start_date ? (
                                                                <>
                                                                    <div className="text-xs font-medium tracking-wide text-accent-700 dark:text-accent-400">
                                                                        {formatDate(event.start_date, { month: 'short' })}
                                                                    </div>
                                                                    <div className="text-lg leading-none font-medium text-zinc-950 dark:text-white">
                                                                        {formatDate(event.start_date, { day: '2-digit' })}
                                                                    </div>
                                                                </>
                                                            ) : (
                                                                <div className="text-center text-[10px] leading-tight font-medium tracking-wide text-zinc-500 uppercase dark:text-zinc-400">
                                                                    Termin
                                                                    <br />
                                                                    offen
                                                                </div>
                                                            )}
                                                        </div>
                                                        <div>
                                                            <div className="line-clamp-1 text-base font-medium text-zinc-950 transition-colors group-hover:text-accent-600 dark:text-white">
                                                                {event.name}
                                                            </div>
                                                            <div className="mt-0.5 flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400">
                                                                <span className="flex items-center gap-1.5 font-medium">
                                                                    {event.showsTimeComponent && event.start_date
                                                                        ? `${formatDate(event.start_date, { hour: '2-digit', minute: '2-digit' })} Uhr`
                                                                        : event.showsDateComponent && event.start_date
                                                                            ? (formatDate(event.start_date, { dateStyle: 'medium' }) ?? 'Termin wird noch bekanntgegeben')
                                                                        : 'Termin wird noch bekanntgegeben'}
                                                                </span>
                                                                {event.location && (
                                                                    <span className="flex max-w-[180px] items-center gap-1.5 truncate font-medium">
                                                                        <MapPin className="size-3" />
                                                                        {event.location}
                                                                    </span>
                                                                )}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ArrowRight className="size-4 text-zinc-300 transition-all group-hover:translate-x-1 group-hover:text-accent-600" />
                                                </Link>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </CardContent>
                        </Card>

                        {/* News Grid */}
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-xs dark:border-white/10">
                            <CardHeader className="border-b border-zinc-100 py-5 dark:border-white/5">
                                <div className="flex items-center justify-between gap-4">
                                    <div>
                                        <CardTitle className="flex items-center gap-2.5 text-xl font-bold">
                                            <Newspaper className="size-5 text-accent-600" />
                                            Aktuelles
                                        </CardTitle>
                                        <CardDescription className="text-sm">Nachrichten aus Moers und Umgebung</CardDescription>
                                    </div>
                                    <Button
                                        asChild
                                        variant="secondary"
                                        size="sm"
                                        className="h-8 rounded-full text-xs"
                                    >
                                        <Link href={route('news.index')}>Newsfeed</Link>
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent className="p-0">
                                {latestNews.length === 0 ? (
                                    <div className="px-6 py-10 text-center text-sm text-zinc-500">Keine aktuellen Nachrichten gefunden.</div>
                                ) : (
                                    <div className="grid divide-y divide-zinc-100 dark:divide-white/5">
                                        {latestNews.map((post) => (
                                            <a
                                                key={post.id}
                                                href={post.external_href || route('news.show', [post.id])}
                                                target={post.external_href ? '_blank' : undefined}
                                                rel="noreferrer"
                                                className="group flex flex-col gap-5 p-6 transition hover:bg-zinc-50 md:flex-row dark:hover:bg-white/5"
                                            >
                                                {post.header_image_url && (
                                                    <div className="relative h-28 w-full shrink-0 overflow-hidden rounded-xl md:w-40">
                                                        <img
                                                            src={post.header_image_url}
                                                            alt={post.title}
                                                            className="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                        />
                                                    </div>
                                                )}
                                                <div className="flex flex-col justify-center py-0.5">
                                                    <div className="space-y-2">
                                                        <div className="flex items-center gap-2.5">
                                                            {post.source_name && (
                                                                <span className="rounded-full bg-accent-50 px-2 py-0.5 text-xs font-medium tracking-wide text-accent-700 dark:bg-accent-500/10 dark:text-accent-400">
                                                                    {post.source_name}
                                                                </span>
                                                            )}
                                                            <span className="text-xs font-medium text-zinc-400">
                                                                {formatDate(post.published_at, { day: '2-digit', month: 'long' })}
                                                            </span>
                                                        </div>
                                                        <h3 className="line-clamp-2 text-lg font-medium text-zinc-950 transition-colors group-hover:text-accent-600 dark:text-white">
                                                            {post.title}
                                                        </h3>
                                                        <p className="line-clamp-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                                            {post.summary}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        ))}
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    <aside className="space-y-6">
                        {/* Abfallkalender Section */}
                        <PrimaryRubbishStreetCard />

                        {/* Live Parking Section */}
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-xs dark:border-white/10">
                            <CardHeader className="border-b border-zinc-100 py-4 dark:border-white/5">
                                <CardTitle className="flex items-center gap-2.5 text-lg font-bold">
                                    <CircleParking className="size-4 text-accent-600" />
                                    Parkhäuser Live
                                </CardTitle>
                                <CardDescription className="text-xs">Aktuelle Belegung im Zentrum</CardDescription>
                            </CardHeader>
                            <CardContent className="p-0">
                                <ul className="divide-y divide-zinc-100 dark:divide-white/5">
                                    {parkingAreas.length > 0 ? (
                                        parkingAreas.map((area) => (
                                            <li
                                                key={area.id}
                                                className="flex items-center justify-between px-5 py-4"
                                            >
                                                <div className="space-y-0.5">
                                                    <div className="text-sm font-medium text-zinc-950 dark:text-white">{area.name}</div>
                                                    <div className="flex items-center gap-1.5 text-xs font-medium tracking-wide">
                                                        <span
                                                            className={`size-1.5 rounded-full ${area.state === 'open' ? 'bg-accent-500' : 'bg-zinc-300'}`}
                                                        />
                                                        <span className={area.state === 'open' ? 'text-accent-600' : 'text-zinc-500'}>
                                                            {area.state === 'open' ? 'Geöffnet' : 'Geschlossen'}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="flex flex-col items-end">
                                                    <div
                                                        className={`text-xl font-medium tracking-tighter tabular-nums ${
                                                            area.capacity && area.occupied && area.capacity - area.occupied < 10
                                                                ? 'text-accent-500'
                                                                : 'text-zinc-950 dark:text-white'
                                                        }`}
                                                    >
                                                        {area.capacity ? Math.max(0, area.capacity - area.occupied!) : '—'}
                                                    </div>
                                                    <div className="text-xs font-medium tracking-wide text-zinc-400">Frei</div>
                                                </div>
                                            </li>
                                        ))
                                    ) : (
                                        <div className="px-5 py-6 text-center text-sm text-zinc-500">Daten werden geladen...</div>
                                    )}
                                </ul>
                                <div className="bg-zinc-50/50 px-5 py-3 dark:bg-white/5">
                                    <div className="flex items-center justify-between">
                                        <div className="text-xs font-medium text-zinc-500">Gesamtparkplätze</div>
                                        <div className="text-xs font-medium text-zinc-950 dark:text-white">{stats.parking_spaces} Plätze</div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </aside>
                </div>
            </DefaultContainer>

            {/* Detailed App Features Section */}
            <section className="relative overflow-hidden bg-zinc-950 py-16 md:py-24">
                <div className="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,_rgba(5,150,105,0.05),_transparent_50%),radial-gradient(circle_at_70%_80%,_rgba(2,132,199,0.05),_transparent_50%)]" />
                <DefaultContainer className="relative">
                    <div className="max-w-2xl">
                        <h2 className="text-3xl font-bold tracking-tight text-white md:text-4xl">Deine Stadt. Deine App.</h2>
                        <p className="mt-4 text-base leading-relaxed text-zinc-400">
                            Die „Mein Moers“-App vereint alle wichtigen Services unserer Stadt in einer Anwendung. Konzipiert for den schnellen
                            Zugriff von unterwegs.
                        </p>
                    </div>

                    <div className="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        {[
                            {
                                title: 'Abfallkalender',
                                description: 'Wähle deine Straße und lass dich am Vorabend an die Müllabfuhr erinnern.',
                                icon: Leaf,
                                color: 'bg-accent-500',
                            },
                            {
                                title: 'Live Parkdaten',
                                description: 'Finde immer den nächsten freien Parkplatz – in Echtzeit aktualisiert.',
                                icon: CircleParking,
                                color: 'bg-accent-500',
                            },
                            {
                                title: 'Stadt-News',
                                description: 'Die neuesten Meldungen der Stadtverwaltung und lokaler Medien.',
                                icon: Newspaper,
                                color: 'bg-accent-500',
                            },
                            {
                                title: 'Event-Highlights',
                                description: 'Verpasse keine Veranstaltung mehr in Moers und Umgebung.',
                                icon: CalendarRange,
                                color: 'bg-rose-500',
                            },
                            {
                                title: 'Radio Moers',
                                description: 'Höre den lokalen Radiosender direkt in der App – egal wo du bist.',
                                icon: Radio,
                                color: 'bg-amber-500',
                            },
                            {
                                title: 'Alles Digital',
                                description: 'Weitere Services und Angebote werden stetig in die App integriert.',
                                icon: Smartphone,
                                color: 'bg-zinc-500',
                            },
                        ].map((feature, i) => (
                            <div
                                key={i}
                                className="group rounded-3xl border border-white/5 bg-white/5 p-6 transition hover:bg-white/10"
                            >
                                <div
                                    className={`inline-flex size-12 items-center justify-center rounded-xl ${feature.color} bg-opacity-10 mb-5 text-white transition-transform group-hover:scale-110`}
                                >
                                    <feature.icon className="size-6" />
                                </div>
                                <h3 className="mb-2 text-lg font-medium text-white">{feature.title}</h3>
                                <p className="text-sm leading-relaxed text-zinc-400">{feature.description}</p>
                            </div>
                        ))}
                    </div>

                    <div className="mt-20 flex flex-col items-center justify-between gap-12 rounded-[2.5rem] border border-white/10 bg-white/5 p-10 lg:flex-row lg:p-14">
                        <div className="space-y-6 text-center lg:text-left">
                            <h3 className="text-2xl font-bold tracking-tight text-white">Jetzt kostenlos laden</h3>
                            <div className="flex flex-wrap justify-center gap-4 lg:justify-start">
                                <MobileAppBadge
                                    href={mobileApps.ios_url}
                                    platform="ios"
                                />
                                <MobileAppBadge
                                    href={mobileApps.android_url}
                                    platform="android"
                                />
                            </div>
                        </div>

                        {/* Screenshots Placeholder Section */}
                        <div className="flex translate-y-8 -rotate-6 gap-4 opacity-40 transition-all duration-700 hover:opacity-100 hover:grayscale-0 lg:translate-y-0">
                            {[0, 1].map((n) => (
                                <div
                                    key={n}
                                    className="h-64 w-36 shrink-0 overflow-hidden rounded-[2rem] border-4 border-zinc-800 bg-zinc-900 shadow-2xl"
                                >
                                    <div className="h-full bg-linear-to-b from-zinc-800 to-zinc-900 p-3">
                                        <div className="h-full rounded-2xl bg-zinc-950/50" />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </DefaultContainer>
            </section>
        </>
    );
}

Home.layout = (page: ReactNode) => <AppLayout children={page} />;

export default Home;
