import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { PageHeader } from '@/components/page-header';
import { RubbishStreetSearch } from '@/components/rubbish-street-search';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { Calendar, ChevronRight, Search, Smartphone, Trash2 } from 'lucide-react';
import { ReactNode } from 'react';

type RubbishStreetListItem = {
    id: number;
    name: string;
    street_addition: string | null;
};

type RubbishIndexProps = {
    filters: {
        q: string;
    };
    streets: Paginator<RubbishStreetListItem>;
};

function RubbishIndex({ filters, streets }: RubbishIndexProps) {
    return (
        <>
            <Head title="Abfallkalender" />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <PageHeader
                    badge={
                        <div className="flex items-center gap-2">
                            <Trash2 className="size-3.5" />
                            Entsorgungstermine
                        </div>
                    }
                    title="Abfallkalender Moers"
                    description="Finden Sie schnell und einfach die nächsten Abholtermine für Ihre Straße. Geben Sie dazu einfach Ihren Straßennamen in das Suchfeld ein."
                >
                    <div className="max-w-2xl">
                        <RubbishStreetSearch
                            initialQuery={filters.q}
                            initialResults={streets.data}
                            autoOpen={Boolean(filters.q)}
                        />
                    </div>
                </PageHeader>

                <DefaultContainer className="py-12">
                    <div className="space-y-12">
                        <div className="max-w-3xl">
                            <Card className="rounded-2xl border-accent-200 bg-linear-to-br from-accent-50 via-white to-accent-50 dark:border-accent-500/20 dark:from-accent-500/10 dark:via-zinc-900 dark:to-accent-500/10">
                                <CardHeader className="pb-4">
                                    <div className="flex items-center gap-3">
                                        <div className="flex size-11 items-center justify-center rounded-2xl bg-white text-accent-700 shadow-sm ring-1 ring-accent-200 dark:bg-zinc-950 dark:ring-white/10">
                                            <Search className="size-5" />
                                        </div>
                                        <div>
                                            <CardTitle className="text-2xl text-zinc-950 dark:text-white">Abfallkalender</CardTitle>
                                            <CardDescription className="mt-1 text-sm text-zinc-700 dark:text-zinc-400">
                                                Finden Sie Ihre Straße für alle Abholtermine.
                                            </CardDescription>
                                        </div>
                                    </div>
                                </CardHeader>
                                <CardContent className="grid gap-3 sm:grid-cols-2">
                                    <div className="rounded-2xl border border-white/70 bg-white/80 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                        <div className="flex items-center gap-2 text-sm font-medium text-zinc-950 dark:text-white">
                                            <Smartphone className="size-4 text-accent-600 dark:text-accent-400" />
                                            Mobile App & Push
                                        </div>
                                        <p className="mt-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                            Nutzen Sie unsere App für automatische Erinnerungen direkt auf Ihr Smartphone.
                                        </p>
                                    </div>
                                    <div className="rounded-2xl border border-white/70 bg-white/80 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                        <div className="flex items-center gap-2 text-sm font-medium text-zinc-950 dark:text-white">
                                            <Calendar className="size-4 text-accent-600 dark:text-accent-400" />
                                            Kalender-Abo
                                        </div>
                                        <p className="mt-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                            Abonnieren Sie alle Termine als iCal-Kalender für Ihr Outlook, Google oder Apple Kalender.
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <div className="space-y-6">
                            <h2 className="text-2xl font-bold tracking-tight text-zinc-950 dark:text-white">Alle Straßen</h2>

                            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {streets.data.map((street) => (
                                    <Link
                                        key={street.id}
                                        href={route('rubbish.show', [street.id])}
                                        className="group flex items-center justify-between rounded-2xl border border-zinc-200 bg-white px-5 py-4 transition hover:border-accent-300 hover:shadow-lg hover:shadow-accent-500/5 dark:border-white/10 dark:bg-zinc-900 dark:hover:border-accent-500/30"
                                    >
                                        <div className="min-w-0">
                                            <div className="truncate font-medium text-zinc-950 dark:text-white">{street.name}</div>
                                            {street.street_addition && (
                                                <div className="truncate text-xs text-zinc-500 dark:text-zinc-400">{street.street_addition}</div>
                                            )}
                                        </div>
                                        <ChevronRight className="size-5 shrink-0 text-zinc-400 transition group-hover:translate-x-0.5 group-hover:text-accent-500" />
                                    </Link>
                                ))}
                            </div>

                            <div className="pt-8">
                                <DefaultPagination paginator={streets} />
                            </div>
                        </div>
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
}

RubbishIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishIndex;
