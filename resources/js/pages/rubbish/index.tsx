import { DefaultContainer } from '@/components/default-container';
import { DefaultPagination } from '@/components/default-pagination';
import { PageHeader } from '@/components/page-header';
import { RubbishStreetSearch } from '@/components/rubbish-street-search';
import { SeoHead } from '@/components/seo-head';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Link } from '@inertiajs/react';
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
            <SeoHead
                title="Abfallkalender für Moers"
                description="Finde die nächsten Abholtermine für deine Straße in Moers und nutze den Abfallkalender für Erinnerungen und Downloads."
            />

            <div className="bg-background min-h-screen">
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
                            <Card className="bg-muted gap-5 shadow-none">
                                <CardHeader className="pb-4">
                                    <div className="flex items-center gap-3">
                                        <div className="text-foreground flex size-11 items-center justify-center rounded-lg">
                                            <Search className="size-5" />
                                        </div>
                                        <div>
                                            <CardTitle className="text-foreground text-2xl">Abfallkalender</CardTitle>
                                            <CardDescription className="text-muted-foreground mt-1 text-sm">
                                                Finden Sie Ihre Straße für alle Abholtermine.
                                            </CardDescription>
                                        </div>
                                    </div>
                                </CardHeader>
                                <CardContent className="grid gap-3 sm:grid-cols-2">
                                    <div className="border-border rounded-lg border px-4 py-3">
                                        <div className="text-foreground flex items-center gap-2 text-sm font-medium">
                                            <Smartphone className="text-accent-600 dark:text-accent-400 size-4" />
                                            Mobile App & Push
                                        </div>
                                        <p className="text-muted-foreground mt-1 text-sm leading-6">
                                            Nutzen Sie unsere App für automatische Erinnerungen direkt auf Ihr Smartphone.
                                        </p>
                                    </div>
                                    <div className="border-border rounded-lg border px-4 py-3">
                                        <div className="text-foreground flex items-center gap-2 text-sm font-medium">
                                            <Calendar className="text-accent-600 dark:text-accent-400 size-4" />
                                            Kalender-Abo
                                        </div>
                                        <p className="text-muted-foreground mt-1 text-sm leading-6">
                                            Abonnieren Sie alle Termine als iCal-Kalender für Ihr Outlook, Google oder Apple Kalender.
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <div className="space-y-6">
                            <h2 className="text-foreground text-2xl font-semibold tracking-tight">Alle Straßen</h2>

                            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {streets.data.map((street) => (
                                    <Link
                                        key={street.id}
                                        href={route('rubbish.show', [street.id])}
                                        className="group border-border bg-card hover:bg-muted focus-visible:outline-ring flex items-center justify-between gap-3 rounded-xl border px-5 py-4 transition-colors focus-visible:outline-2 focus-visible:outline-offset-4"
                                    >
                                        <div className="min-w-0">
                                            <div className="text-foreground truncate font-medium">{street.name}</div>
                                            {street.street_addition && (
                                                <div className="text-muted-foreground truncate text-xs">{street.street_addition}</div>
                                            )}
                                        </div>
                                        <ChevronRight className="text-muted-foreground size-[18px] shrink-0 transition-transform group-hover:translate-x-0.5" />
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
