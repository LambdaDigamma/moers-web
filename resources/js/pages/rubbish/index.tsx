import { DefaultContainer } from '@/components/default-container';
import { RubbishStreetSearch } from '@/components/rubbish-street-search';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { Compass, Search } from 'lucide-react';
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
    streets: RubbishStreetListItem[];
};

function RubbishIndex({ filters, streets }: RubbishIndexProps) {
    return (
        <>
            <Head title="Abfallkalender" />

            <DefaultContainer className="space-y-6 py-6">
                <RubbishStreetSearch
                    initialQuery={filters.q}
                    initialResults={streets}
                    autoOpen={Boolean(filters.q)}
                />

                <div className="mx-auto max-w-3xl pt-2">
                    <Card className="border-emerald-200 bg-linear-to-br from-emerald-50 via-white to-lime-50">
                        <CardHeader className="pb-4">
                            <div className="flex items-center gap-3">
                                <div className="flex size-11 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200">
                                    <Search className="size-5" />
                                </div>
                                <div>
                                    <CardTitle className="text-2xl text-zinc-950">Abfallkalender</CardTitle>
                                    <CardDescription className="mt-1 text-sm text-zinc-700">
                                        Suche deine Straße direkt oben und springe ohne Umweg in die Termine.
                                    </CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent className="grid gap-3 sm:grid-cols-2">
                            <div className="rounded-2xl border border-white/70 bg-white/80 px-4 py-3">
                                <div className="flex items-center gap-2 text-sm font-medium text-zinc-950">
                                    <Compass className="size-4 text-emerald-600" />
                                    Schnell wechseln
                                </div>
                                <p className="mt-1 text-sm leading-6 text-zinc-600">
                                    Die Ergebnisliste schwebt direkt unter der Suche. Ein Klick öffnet sofort die passende Straße.
                                </p>
                            </div>
                            <div className="rounded-2xl border border-white/70 bg-white/80 px-4 py-3">
                                <div className="text-sm font-medium text-zinc-950">Schreibweise egal</div>
                                <p className="mt-1 text-sm leading-6 text-zinc-600">
                                    Auch Eingaben wie <span className="font-medium text-zinc-950">Goethestrasse</span> finden weiterhin{' '}
                                    <span className="font-medium text-zinc-950">Goethestraße</span>.
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </DefaultContainer>
        </>
    );
}

RubbishIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishIndex;
