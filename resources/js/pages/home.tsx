import { DefaultContainer } from '@/components/default-container';
import { PrimaryRubbishStreetCard } from '@/components/primary-rubbish-street-card';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight, Building2, CalendarRange, ChevronRight, CircleParking, Leaf, MapPin, Newspaper, Radio, Smartphone, Star } from 'lucide-react';
import { ReactNode } from 'react';

type HomeProps = {
    stats: {
        upcoming_events: number;
        news_posts: number;
        organisations: number;
        rubbish_streets: number;
        parking_spaces: number;
    };
    upcomingEvents: {
        id: number;
        name: string;
        start_date: string | null;
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
    featuredOrganisations: {
        id: number;
        name: string;
        slug: string | null;
        description: string | null;
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
        className="inline-flex w-full items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-5 py-3.5 transition hover:bg-white/10 sm:w-auto dark:hover:bg-white/15"
    >
        {platform === 'ios' ? (
            <svg
                viewBox="0 0 384 512"
                className="size-6 fill-white"
            >
                <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z" />
            </svg>
        ) : (
            <svg
                viewBox="0 0 512 512"
                className="size-6 fill-white"
            >
                <path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-10.3 18-28.5-1.2-40.8zM325.3 277.7l60.1 60.1L104.6 499l220.7-221.3z" />
            </svg>
        )}
        <div className="text-left">
            <div className="mb-1 text-[10px] leading-none tracking-[0.16em] text-zinc-400 uppercase">
                {platform === 'ios' ? 'Erhältlich im' : 'Erhältlich bei'}
            </div>
            <div className="text-sm leading-none font-semibold tracking-tight text-white">{platform === 'ios' ? 'App Store' : 'Google Play'}</div>
        </div>
    </a>
);

function Home({ stats, upcomingEvents, latestNews, featuredOrganisations, parkingAreas, mobileApps }: HomeProps) {
    return (
        <>
            <Head title="Mein Moers" />

            <div className="bg-[radial-gradient(circle_at_top_left,_rgba(238,242,255,0.95),_transparent_28%),radial-gradient(circle_at_top_right,_rgba(209,250,229,0.85),_transparent_30%),linear-gradient(180deg,_#f7f7f4_0%,_#ffffff_52%,_#f3f4f6_100%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.18),_transparent_26%),radial-gradient(circle_at_top_right,_rgba(16,185,129,0.16),_transparent_28%),linear-gradient(180deg,_#09090b_0%,_#111827_52%,_#09090b_100%)]">
                <DefaultContainer className="py-10 md:py-16">
                    <div className="grid gap-12 lg:grid-cols-[1fr_400px]">
                        <section className="space-y-8">
                            <div className="inline-flex items-center rounded-full border border-emerald-200/80 bg-white/80 px-4 py-1.5 text-[11px] font-bold tracking-[0.18em] text-emerald-800 uppercase shadow-sm backdrop-blur dark:border-emerald-500/30 dark:bg-white/5 dark:text-emerald-200">
                                <Star className="mr-2 size-3.5 fill-current" />
                                Alle städtischen Services auf einen Blick
                            </div>

                            <div className="space-y-5">
                                <h1 className="max-w-3xl text-4xl leading-[1.1] font-semibold tracking-tight text-zinc-950 md:text-7xl dark:text-white">
                                    Moers – digital, <br />
                                    einfach und direkt.
                                </h1>
                                <p className="max-w-2xl text-lg leading-relaxed text-zinc-700 md:text-xl dark:text-zinc-300">
                                    Aktuelle Nachrichten, Veranstaltungen und der Abfallkalender für deine Straße. Alles an einem Ort, auch ohne Login
                                    nutzbar.
                                </p>
                            </div>

                            <div className="flex flex-wrap gap-4">
                                <Button
                                    asChild
                                    size="lg"
                                    className="h-12 bg-emerald-600 px-8 text-white shadow-lg shadow-emerald-600/20 transition-colors hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600"
                                >
                                    <Link href={route('events.index')}>Entdecken</Link>
                                </Button>
                                <Button
                                    asChild
                                    size="lg"
                                    variant="outline"
                                    className="h-12 border-zinc-300 px-8 dark:border-white/10"
                                >
                                    <Link href="/abfallkalender">Abfallkalender</Link>
                                </Button>
                            </div>

                            <div className="grid grid-cols-2 gap-4 sm:grid-cols-4">
                                {[
                                    { label: 'Events', value: stats.upcoming_events, icon: CalendarRange, color: 'text-emerald-600' },
                                    { label: 'News', value: stats.news_posts, icon: Newspaper, color: 'text-sky-600' },
                                    { label: 'Vereine', value: stats.organisations, icon: Building2, color: 'text-amber-600' },
                                    { label: 'Parken', value: stats.parking_spaces, icon: CircleParking, color: 'text-indigo-600' },
                                ].map((stat, i) => (
                                    <div
                                        key={i}
                                        className="group relative overflow-hidden rounded-3xl border border-white/70 bg-white/50 p-6 shadow-sm backdrop-blur-md transition-all hover:shadow-md dark:border-white/10 dark:bg-white/5"
                                    >
                                        <stat.icon className={`mb-3 size-5 ${stat.color} opacity-80 transition-transform group-hover:scale-110`} />
                                        <div className="text-3xl leading-none font-bold tracking-tight text-zinc-950 dark:text-white">
                                            {stat.value}
                                        </div>
                                        <div className="mt-2 text-xs font-medium tracking-widest text-zinc-500 uppercase">{stat.label}</div>
                                    </div>
                                ))}
                            </div>
                        </section>

                        <div className="relative">
                            {/* Mobile App Teaser Card */}
                            <Card className="sticky top-8 overflow-hidden border-0 bg-zinc-950 text-white shadow-2xl shadow-zinc-950/40">
                                <div className="absolute inset-0 bg-linear-to-br from-emerald-600/20 via-sky-600/20 to-amber-600/10 opacity-50" />
                                <div className="relative p-8">
                                    <div className="mb-8 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.18em] uppercase">
                                        <Smartphone className="size-3.5" />
                                        App Store
                                    </div>

                                    <div className="space-y-4">
                                        <h2 className="text-3xl font-bold tracking-tight">Mein Moers App</h2>
                                        <p className="text-base leading-relaxed text-zinc-300">
                                            Hol dir das volle Moers-Erlebnis mit Push-Nachrichten für den Abfallkalender und alle städtischen Infos
                                            live auf dein Smartphone.
                                        </p>
                                    </div>

                                    <div className="mt-10 grid gap-4">
                                        <MobileAppBadge
                                            href={mobileApps.ios_url}
                                            platform="ios"
                                        />
                                        <MobileAppBadge
                                            href={mobileApps.android_url}
                                            platform="android"
                                        />
                                    </div>

                                    <div className="mt-12 flex items-center justify-center">
                                        {/* Phone Mockup Placeholder */}
                                        <div className="relative h-64 w-40 overflow-hidden rounded-[2.5rem] border-4 border-zinc-800 bg-zinc-900 shadow-xl ring-1 ring-white/10">
                                            <div className="absolute top-0 left-1/2 h-5 w-20 -translate-x-1/2 rounded-b-xl bg-zinc-800" />
                                            <div className="space-y-4 p-4">
                                                <div className="h-2 w-12 rounded-full bg-zinc-800" />
                                                <div className="space-y-2">
                                                    <div className="h-10 rounded-xl bg-emerald-500/20" />
                                                    <div className="h-10 rounded-xl bg-sky-500/20" />
                                                    <div className="h-10 rounded-xl bg-amber-500/20" />
                                                </div>
                                            </div>
                                            <div className="absolute inset-0 bg-linear-to-t from-zinc-900 via-transparent to-transparent" />
                                        </div>
                                    </div>
                                </div>
                            </Card>
                        </div>
                    </div>
                </DefaultContainer>
            </div>

            <DefaultContainer className="space-y-12 py-16 md:py-24">
                {/* Featured Content Grid */}
                <div className="grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">
                    <div className="space-y-8">
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-sm dark:border-white/10">
                            <CardHeader className="border-b border-zinc-100 py-6 dark:border-white/5">
                                <div className="flex items-center justify-between gap-4">
                                    <div>
                                        <CardTitle className="flex items-center gap-3 text-2xl font-bold">
                                            <CalendarRange className="size-6 text-emerald-600" />
                                            Veranstaltungen
                                        </CardTitle>
                                        <CardDescription>Was ist los in unserer Stadt?</CardDescription>
                                    </div>
                                    <Button
                                        asChild
                                        variant="secondary"
                                        size="sm"
                                        className="rounded-full"
                                    >
                                        <Link href={route('events.index')}>Alle Termine</Link>
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent className="p-0">
                                {upcomingEvents.length === 0 ? (
                                    <div className="px-8 py-12 text-center text-sm text-zinc-500">
                                        Aktuell sind keine Veranstaltungen eingetragen.
                                    </div>
                                ) : (
                                    <ul className="divide-y divide-zinc-100 dark:divide-white/5">
                                        {upcomingEvents.map((event) => (
                                            <li key={event.id}>
                                                <Link
                                                    href={route('events.show', [event.id])}
                                                    className="group flex items-center justify-between gap-6 px-8 py-6 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                                >
                                                    <div className="flex items-center gap-6">
                                                        <div className="flex size-14 flex-col items-center justify-center rounded-2xl bg-zinc-100 transition-colors group-hover:bg-emerald-50 dark:bg-white/5 dark:group-hover:bg-emerald-500/10">
                                                            <div className="text-[10px] font-bold tracking-wider text-emerald-700 uppercase dark:text-emerald-400">
                                                                {formatDate(event.start_date, { month: 'short' })}
                                                            </div>
                                                            <div className="text-xl font-bold text-zinc-950 dark:text-white">
                                                                {formatDate(event.start_date, { day: '2-digit' })}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div className="line-clamp-1 text-lg font-semibold text-zinc-950 transition-colors group-hover:text-emerald-600 dark:text-white">
                                                                {event.name}
                                                            </div>
                                                            <div className="mt-1 flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                                                <span className="flex items-center gap-1.5 text-[10px] font-medium tracking-wide uppercase">
                                                                    {formatDate(event.start_date, { hour: '2-digit', minute: '2-digit' })} Uhr
                                                                </span>
                                                                {event.location && (
                                                                    <span className="flex max-w-[200px] items-center gap-1.5 truncate">
                                                                        <MapPin className="size-3.5" />
                                                                        {event.location}
                                                                    </span>
                                                                )}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ArrowRight className="size-5 text-zinc-300 transition-all group-hover:translate-x-1 group-hover:text-emerald-600" />
                                                </Link>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </CardContent>
                        </Card>

                        {/* News Grid */}
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-1">
                            <Card className="overflow-hidden border-zinc-200 py-0 shadow-sm dark:border-white/10">
                                <CardHeader className="border-b border-zinc-100 py-6 dark:border-white/5">
                                    <div className="flex items-center justify-between gap-4">
                                        <div>
                                            <CardTitle className="flex items-center gap-3 text-2xl font-bold">
                                                <Newspaper className="size-6 text-sky-600" />
                                                Aktuelles
                                            </CardTitle>
                                            <CardDescription>Nachrichten aus Moers und Umgebung</CardDescription>
                                        </div>
                                        <Button
                                            asChild
                                            variant="secondary"
                                            size="sm"
                                            className="rounded-full"
                                        >
                                            <Link href={route('news.index')}>Newsfeed</Link>
                                        </Button>
                                    </div>
                                </CardHeader>
                                <CardContent className="p-0">
                                    {latestNews.length === 0 ? (
                                        <div className="px-8 py-12 text-center text-sm text-zinc-500">Keine aktuellen Nachrichten gefunden.</div>
                                    ) : (
                                        <div className="grid divide-y divide-zinc-100 dark:divide-white/5">
                                            {latestNews.map((post) => (
                                                <a
                                                    key={post.id}
                                                    href={post.external_href || route('news.show', [post.id])}
                                                    target={post.external_href ? '_blank' : undefined}
                                                    rel="noreferrer"
                                                    className="group flex flex-col gap-6 p-8 transition hover:bg-zinc-50 md:flex-row dark:hover:bg-white/5"
                                                >
                                                    {post.header_image_url && (
                                                        <div className="relative h-32 w-full shrink-0 overflow-hidden rounded-2xl md:w-48">
                                                            <img
                                                                src={post.header_image_url}
                                                                alt={post.title}
                                                                className="size-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                            />
                                                            <div className="absolute inset-0 rounded-2xl ring-1 ring-black/5 ring-inset" />
                                                        </div>
                                                    )}
                                                    <div className="flex flex-col justify-between py-1">
                                                        <div className="space-y-3">
                                                            <div className="flex items-center gap-3">
                                                                {post.source_name && (
                                                                    <span className="rounded-full bg-sky-50 px-3 py-1 text-[10px] font-bold tracking-wider text-sky-700 uppercase dark:bg-sky-500/10 dark:text-sky-400">
                                                                        {post.source_name}
                                                                    </span>
                                                                )}
                                                                <span className="text-[11px] font-medium tracking-wide text-zinc-400 uppercase">
                                                                    {formatDate(post.published_at, { day: '2-digit', month: 'long' })}
                                                                </span>
                                                            </div>
                                                            <h3 className="line-clamp-2 text-xl font-bold text-zinc-950 transition-colors group-hover:text-sky-600 dark:text-white">
                                                                {post.title}
                                                            </h3>
                                                            <p className="line-clamp-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
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
                    </div>

                    <aside className="space-y-8">
                        {/* Abfallkalender Section */}
                        <PrimaryRubbishStreetCard />

                        {/* Live Parking Section */}
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-sm dark:border-white/10">
                            <CardHeader className="border-b border-zinc-200/80 py-5 dark:border-white/5">
                                <CardTitle className="flex items-center gap-3 text-xl font-bold">
                                    <CircleParking className="size-5 text-indigo-600" />
                                    Parkhäuser Live
                                </CardTitle>
                                <CardDescription>Aktuelle Belegung im Zentrum</CardDescription>
                            </CardHeader>
                            <CardContent className="p-0">
                                <ul className="divide-y divide-zinc-100 dark:divide-white/5">
                                    {parkingAreas.length > 0 ? (
                                        parkingAreas.map((area) => (
                                            <li
                                                key={area.id}
                                                className="flex items-center justify-between px-6 py-5"
                                            >
                                                <div className="space-y-1">
                                                    <div className="font-semibold text-zinc-950 dark:text-white">{area.name}</div>
                                                    <div className="flex items-center gap-2 text-[11px] font-bold tracking-wide uppercase">
                                                        <span
                                                            className={`size-2 rounded-full ${area.state === 'open' ? 'bg-emerald-500' : 'bg-zinc-300'}`}
                                                        />
                                                        <span className={area.state === 'open' ? 'text-emerald-600' : 'text-zinc-500'}>
                                                            {area.state === 'open' ? 'Geöffnet' : 'Geschlossen'}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="flex flex-col items-end">
                                                    <div
                                                        className={`text-2xl font-black tracking-tighter tabular-nums ${
                                                            area.capacity && area.occupied && area.capacity - area.occupied < 10
                                                                ? 'text-amber-500'
                                                                : 'text-zinc-950 dark:text-white'
                                                        }`}
                                                    >
                                                        {area.capacity ? Math.max(0, area.capacity - area.occupied!) : '—'}
                                                    </div>
                                                    <div className="text-[10px] font-bold tracking-widest text-zinc-400 uppercase">Plätze frei</div>
                                                </div>
                                            </li>
                                        ))
                                    ) : (
                                        <div className="px-6 py-8 text-center text-sm text-zinc-500">Parkdaten werden geladen...</div>
                                    )}
                                </ul>
                                <div className="bg-zinc-50 px-6 py-4 dark:bg-white/5">
                                    <div className="flex items-center justify-between">
                                        <div className="text-xs font-medium text-zinc-500">Insgesamt</div>
                                        <div className="text-xs font-bold tracking-wider text-zinc-950 uppercase dark:text-white">
                                            {stats.parking_spaces} Parkplätze
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Organisations Widget */}
                        <Card className="overflow-hidden border-zinc-200 py-0 shadow-sm dark:border-white/10">
                            <CardHeader className="border-b border-zinc-200/80 py-5 dark:border-white/5">
                                <div className="flex items-center justify-between gap-4">
                                    <CardTitle className="flex items-center gap-3 text-xl font-bold">
                                        <Building2 className="size-5 text-amber-600" />
                                        Organisationen
                                    </CardTitle>
                                    <Button
                                        asChild
                                        variant="ghost"
                                        size="icon"
                                        className="rounded-full"
                                    >
                                        <Link href={route('organisations.index')}>
                                            <ChevronRight className="size-4" />
                                        </Link>
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent className="grid gap-3 p-4">
                                {featuredOrganisations.map((org) => (
                                    <Link
                                        key={org.id}
                                        href={route('organisations.show', [org.slug])}
                                        className="flex items-center gap-3 rounded-2xl border border-zinc-100 bg-zinc-50/50 p-3 transition-all hover:border-zinc-200 hover:bg-white hover:shadow-sm dark:border-white/5 dark:bg-white/5 dark:hover:bg-white/10"
                                    >
                                        <div className="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-xs font-bold text-amber-700 uppercase dark:bg-amber-500/10 dark:text-amber-400">
                                            {org.name.charAt(0)}
                                        </div>
                                        <div className="min-w-0">
                                            <div className="truncate text-sm font-semibold text-zinc-950 dark:text-white">{org.name}</div>
                                            <div className="truncate text-xs text-zinc-500">Moerser Verein</div>
                                        </div>
                                    </Link>
                                ))}
                            </CardContent>
                        </Card>
                    </aside>
                </div>
            </DefaultContainer>

            {/* Detailed App Features Section */}
            <section className="relative overflow-hidden bg-zinc-950 py-24 lg:py-32">
                <div className="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,_rgba(5,150,105,0.1),_transparent_50%),radial-gradient(circle_at_70%_80%,_rgba(2,132,199,0.1),_transparent_50%)]" />
                <DefaultContainer className="relative">
                    <div className="max-w-3xl">
                        <h2 className="text-4xl font-bold tracking-tight text-white md:text-5xl lg:text-6xl">
                            Deine Stadt. <br />
                            Deine App.
                        </h2>
                        <p className="mt-6 text-lg leading-relaxed text-zinc-400">
                            Die „Mein Moers“-App vereint alle wichtigen Services unserer Stadt in einer Anwendung. Konzipiert für den schnellen
                            Zugriff von unterwegs.
                        </p>
                    </div>

                    <div className="mt-20 grid gap-12 lg:grid-cols-3">
                        {[
                            {
                                title: 'Abfallkalender',
                                description: 'Wähle deine Straße und lass dich am Vorabend an die Müllabfuhr erinnern.',
                                icon: Leaf,
                                color: 'bg-emerald-500',
                            },
                            {
                                title: 'Live Parkdaten',
                                description: 'Finde immer den nächsten freien Parkplatz – in Echtzeit aktualisiert.',
                                icon: CircleParking,
                                color: 'bg-indigo-500',
                            },
                            {
                                title: 'Stadt-News',
                                description: 'Die neuesten Meldungen der Stadtverwaltung und lokaler Medien.',
                                icon: Newspaper,
                                color: 'bg-sky-500',
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
                                title: 'Vereinsverzeichnis',
                                description: 'Entdecke das vielfältige Angebot der Moerser Vereine und Initiativen.',
                                icon: Building2,
                                color: 'bg-zinc-500',
                            },
                        ].map((feature, i) => (
                            <div
                                key={i}
                                className="group relative"
                            >
                                <div
                                    className={`inline-flex size-14 items-center justify-center rounded-2xl ${feature.color} bg-opacity-10 mb-6 text-white transition-transform group-hover:scale-110`}
                                >
                                    <feature.icon className="size-7" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-white">{feature.title}</h3>
                                <p className="leading-relaxed text-zinc-400">{feature.description}</p>
                            </div>
                        ))}
                    </div>

                    <div className="mt-24 flex flex-col items-center justify-between gap-12 rounded-[3rem] border border-white/10 bg-white/5 p-12 lg:flex-row lg:p-16">
                        <div className="space-y-6">
                            <h3 className="text-3xl font-bold tracking-tight text-white">Jetzt kostenlos laden</h3>
                            <div className="flex flex-wrap gap-4">
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
                        <div className="flex translate-y-12 -rotate-12 gap-6 opacity-50 grayscale transition-all duration-700 hover:opacity-100 hover:grayscale-0 lg:translate-y-0">
                            {[0, 1].map((n) => (
                                <div
                                    key={n}
                                    className="h-80 w-44 shrink-0 overflow-hidden rounded-[2.5rem] border-4 border-zinc-800 bg-zinc-900 shadow-2xl ring-1 ring-white/10"
                                >
                                    <div className="space-y-4 p-4">
                                        <div className="h-2 w-12 rounded-full bg-zinc-800" />
                                        <div className="space-y-2">
                                            <div className="h-20 rounded-xl bg-zinc-800" />
                                            <div className="h-20 rounded-xl bg-zinc-800" />
                                            <div className="h-20 rounded-xl bg-zinc-800" />
                                        </div>
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
