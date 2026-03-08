import { DefaultContainer } from '@/components/default-container';
import { PrimaryRubbishStreetCard } from '@/components/primary-rubbish-street-card';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight, Building2, CalendarRange, Newspaper, Smartphone } from 'lucide-react';
import { ReactNode } from 'react';

type HomeProps = {
    stats: {
        upcoming_events: number;
        news_posts: number;
        organisations: number;
        rubbish_streets: number;
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
    }[];
    featuredOrganisations: {
        id: number;
        name: string;
        slug: string | null;
        description: string | null;
    }[];
    mobileApps: {
        ios_url: string;
        android_url: string;
    };
};

const formatDate = (value: string | null, options: Intl.DateTimeFormatOptions) => {
    if (! value) {
        return null;
    }

    return new Intl.DateTimeFormat('de-DE', options).format(new Date(value));
};

function Home({ stats, upcomingEvents, latestNews, featuredOrganisations, mobileApps }: HomeProps) {
    return (
        <>
            <Head title="Mein Moers" />

            <div className="bg-[radial-gradient(circle_at_top_left,_rgba(238,242,255,0.95),_transparent_28%),radial-gradient(circle_at_top_right,_rgba(209,250,229,0.85),_transparent_30%),linear-gradient(180deg,_#f7f7f4_0%,_#ffffff_52%,_#f3f4f6_100%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.18),_transparent_26%),radial-gradient(circle_at_top_right,_rgba(16,185,129,0.16),_transparent_28%),linear-gradient(180deg,_#09090b_0%,_#111827_52%,_#09090b_100%)]">
                <DefaultContainer className="py-10 md:py-16">
                    <div className="grid gap-8 lg:grid-cols-[minmax(0,1.3fr)_minmax(18rem,0.9fr)]">
                        <section className="space-y-6">
                            <div className="inline-flex items-center rounded-full border border-emerald-200/80 bg-white/80 px-3 py-1 text-xs font-medium tracking-[0.18em] text-emerald-800 uppercase shadow-sm backdrop-blur dark:border-emerald-500/30 dark:bg-white/5 dark:text-emerald-200">
                                Stadtinfos, Veranstaltungen und Services an einem Ort
                            </div>

                            <div className="space-y-4">
                                <h1 className="max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 md:text-6xl dark:text-white">
                                    Mein Moers macht lokale Informationen auch ohne Login sofort nutzbar.
                                </h1>
                                <p className="max-w-2xl text-base leading-7 text-zinc-700 md:text-lg dark:text-zinc-300">
                                    Nachrichten, Veranstaltungen, Organisationen und der Abfallkalender sind jetzt direkt
                                    oeffentlich erreichbar. Fuer unterwegs gibt es die Apps weiterhin fuer iPhone und Android.
                                </p>
                            </div>

                            <div className="flex flex-wrap gap-3">
                                <Button
                                    asChild
                                    className="bg-zinc-950 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-950 dark:hover:bg-zinc-200"
                                >
                                    <Link href={route('events.index')}>Veranstaltungen ansehen</Link>
                                </Button>
                                <Button
                                    asChild
                                    variant="outline"
                                >
                                    <Link href="/abfallkalender">Abfallkalender oeffnen</Link>
                                </Button>
                            </div>

                            <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                <Card className="border-white/70 bg-white/80 py-4 shadow-md backdrop-blur dark:border-white/10 dark:bg-white/5">
                                    <CardHeader className="gap-2 pb-0">
                                        <CardDescription>Kommende Termine</CardDescription>
                                        <CardTitle className="text-3xl">{stats.upcoming_events}</CardTitle>
                                    </CardHeader>
                                </Card>
                                <Card className="border-white/70 bg-white/80 py-4 shadow-md backdrop-blur dark:border-white/10 dark:bg-white/5">
                                    <CardHeader className="gap-2 pb-0">
                                        <CardDescription>Aktuelle Meldungen</CardDescription>
                                        <CardTitle className="text-3xl">{stats.news_posts}</CardTitle>
                                    </CardHeader>
                                </Card>
                                <Card className="border-white/70 bg-white/80 py-4 shadow-md backdrop-blur dark:border-white/10 dark:bg-white/5">
                                    <CardHeader className="gap-2 pb-0">
                                        <CardDescription>Organisationen</CardDescription>
                                        <CardTitle className="text-3xl">{stats.organisations}</CardTitle>
                                    </CardHeader>
                                </Card>
                                <Card className="border-white/70 bg-white/80 py-4 shadow-md backdrop-blur dark:border-white/10 dark:bg-white/5">
                                    <CardHeader className="gap-2 pb-0">
                                        <CardDescription>Abfallkalender-Strassen</CardDescription>
                                        <CardTitle className="text-3xl">{stats.rubbish_streets}</CardTitle>
                                    </CardHeader>
                                </Card>
                            </div>
                        </section>

                        <Card className="overflow-hidden border-zinc-200/70 bg-zinc-950 py-0 text-white shadow-2xl shadow-zinc-950/15 dark:border-white/10">
                            <div className="bg-[linear-gradient(135deg,_rgba(34,197,94,0.16),_rgba(59,130,246,0.18),_rgba(250,204,21,0.14))] p-6">
                                <div className="mb-8 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.18em] uppercase">
                                    <Smartphone className="size-3.5" />
                                    Mobile Apps
                                </div>
                                <div className="space-y-3">
                                    <h2 className="text-2xl font-semibold">Moers in der Tasche</h2>
                                    <p className="text-sm leading-6 text-zinc-200">
                                        Die mobilen Apps bleiben der schnellste Weg fuer Push-Nachrichten, den
                                        Abfallkalender und lokale Infos unterwegs.
                                    </p>
                                </div>
                            </div>
                            <CardContent className="space-y-4 p-6">
                                <a
                                    href={mobileApps.ios_url}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-4 transition hover:bg-white/10"
                                >
                                    <div>
                                        <div className="text-xs uppercase tracking-[0.18em] text-zinc-400">iPhone und iPad</div>
                                        <div className="mt-1 text-lg font-medium">Im App Store laden</div>
                                    </div>
                                    <ArrowRight className="size-5 text-zinc-300" />
                                </a>
                                <a
                                    href={mobileApps.android_url}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-4 transition hover:bg-white/10"
                                >
                                    <div>
                                        <div className="text-xs uppercase tracking-[0.18em] text-zinc-400">Android</div>
                                        <div className="mt-1 text-lg font-medium">Bei Google Play laden</div>
                                    </div>
                                    <ArrowRight className="size-5 text-zinc-300" />
                                </a>
                            </CardContent>
                        </Card>
                    </div>
                </DefaultContainer>
            </div>

            <DefaultContainer className="space-y-8 py-10 md:py-14">
                <div className="grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)]">
                    <Card className="border-zinc-200 py-0 dark:border-white/10">
                        <CardHeader className="border-b border-zinc-200/80 py-6 dark:border-white/10">
                            <div className="flex items-center justify-between gap-4">
                                <div>
                                    <CardTitle className="flex items-center gap-2 text-2xl">
                                        <CalendarRange className="size-5 text-emerald-600" />
                                        Naechste Veranstaltungen
                                    </CardTitle>
                                    <CardDescription>Oeffentlich sichtbar und direkt aufrufbar</CardDescription>
                                </div>
                                <Button
                                    asChild
                                    variant="ghost"
                                >
                                    <Link href={route('events.index')}>Alle</Link>
                                </Button>
                            </div>
                        </CardHeader>
                        <CardContent className="p-0">
                            {upcomingEvents.length === 0 ? (
                                <div className="px-6 py-8 text-sm text-zinc-500 dark:text-zinc-400">
                                    Aktuell sind keine kommenden Veranstaltungen eingetragen.
                                </div>
                            ) : (
                                <ul className="divide-y divide-zinc-200 dark:divide-white/10">
                                    {upcomingEvents.map((event) => (
                                        <li key={event.id}>
                                            <Link
                                                href={route('events.show', [event.id])}
                                                className="flex items-start justify-between gap-4 px-6 py-4 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                            >
                                                <div>
                                                    <div className="font-medium text-zinc-950 dark:text-white">{event.name}</div>
                                                    <div className="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                                        {formatDate(event.start_date, {
                                                            day: '2-digit',
                                                            month: 'long',
                                                            hour: '2-digit',
                                                            minute: '2-digit',
                                                        }) ?? 'Termin folgt'}
                                                        {event.location ? ` · ${event.location}` : ''}
                                                    </div>
                                                </div>
                                                <ArrowRight className="mt-1 size-4 shrink-0 text-zinc-400" />
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </CardContent>
                    </Card>

                    <PrimaryRubbishStreetCard />
                </div>

                <div className="grid gap-6 xl:grid-cols-2">
                    <Card className="border-zinc-200 py-0 dark:border-white/10">
                        <CardHeader className="border-b border-zinc-200/80 py-6 dark:border-white/10">
                            <div className="flex items-center justify-between gap-4">
                                <div>
                                    <CardTitle className="flex items-center gap-2 text-2xl">
                                        <Newspaper className="size-5 text-sky-600" />
                                        Aktuelle Nachrichten
                                    </CardTitle>
                                    <CardDescription>Neu im oeffentlichen Bereich</CardDescription>
                                </div>
                                <Button
                                    asChild
                                    variant="ghost"
                                >
                                    <Link href={route('news.index')}>Alle</Link>
                                </Button>
                            </div>
                        </CardHeader>
                        <CardContent className="p-0">
                            {latestNews.length === 0 ? (
                                <div className="px-6 py-8 text-sm text-zinc-500 dark:text-zinc-400">
                                    Aktuell sind keine Nachrichten veroeffentlicht.
                                </div>
                            ) : (
                                <ul className="divide-y divide-zinc-200 dark:divide-white/10">
                                    {latestNews.map((post) => (
                                        <li key={post.id}>
                                            <Link
                                                href={route('news.show', [post.id])}
                                                className="block px-6 py-4 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                            >
                                                <div className="font-medium text-zinc-950 dark:text-white">{post.title}</div>
                                                <div className="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                                    {post.summary ?? 'Keine Kurzbeschreibung hinterlegt.'}
                                                </div>
                                                <div className="mt-3 text-xs uppercase tracking-[0.16em] text-zinc-400">
                                                    {formatDate(post.published_at, {
                                                        day: '2-digit',
                                                        month: 'long',
                                                        year: 'numeric',
                                                    }) ?? 'Neu'}
                                                </div>
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="border-zinc-200 py-0 dark:border-white/10">
                        <CardHeader className="border-b border-zinc-200/80 py-6 dark:border-white/10">
                            <div className="flex items-center justify-between gap-4">
                                <div>
                                    <CardTitle className="flex items-center gap-2 text-2xl">
                                        <Building2 className="size-5 text-amber-600" />
                                        Organisationen
                                    </CardTitle>
                                    <CardDescription>Vereine, Initiativen und lokale Angebote</CardDescription>
                                </div>
                                <Button
                                    asChild
                                    variant="ghost"
                                >
                                    <Link href={route('organisations.index')}>Alle</Link>
                                </Button>
                            </div>
                        </CardHeader>
                        <CardContent className="grid gap-3 py-6 sm:grid-cols-2">
                            {featuredOrganisations.length === 0 ? (
                                <div className="text-sm text-zinc-500 dark:text-zinc-400">
                                    Aktuell sind keine Organisationen hinterlegt.
                                </div>
                            ) : (
                                featuredOrganisations.map((organisation) => (
                                    <Link
                                        key={organisation.id}
                                        href={route('organisations.show', [organisation.slug])}
                                        className="rounded-2xl border border-zinc-200 px-4 py-4 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-white/10 dark:hover:border-white/20 dark:hover:bg-white/5"
                                    >
                                        <div className="font-medium text-zinc-950 dark:text-white">{organisation.name}</div>
                                        <div className="mt-2 line-clamp-3 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                            {organisation.description || 'Mehr Informationen zur Organisation aufrufen.'}
                                        </div>
                                    </Link>
                                ))
                            )}
                        </CardContent>
                    </Card>
                </div>
            </DefaultContainer>
        </>
    );
}

Home.layout = (page: ReactNode) => <AppLayout children={page} />;

export default Home;
