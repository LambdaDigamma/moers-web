import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router } from '@inertiajs/react';
import { ArrowRight, Search } from 'lucide-react';
import { FormEvent, ReactNode, useEffect, useRef, useState } from 'react';

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
    const [query, setQuery] = useState(filters.q ?? '');
    const [isSearching, setIsSearching] = useState(false);
    const timeoutRef = useRef<number | null>(null);
    const lastSubmittedQueryRef = useRef(filters.q ?? '');
    const visibleResultQuery = isSearching ? query : filters.q;

    useEffect(() => {
        if (query === lastSubmittedQueryRef.current) {
            return;
        }

        if (timeoutRef.current !== null) {
            window.clearTimeout(timeoutRef.current);
        }

        setIsSearching(true);

        timeoutRef.current = window.setTimeout(() => {
            lastSubmittedQueryRef.current = query;

            router.get(
                '/abfallkalender',
                query === '' ? {} : { q: query },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ['filters', 'streets'],
                    onFinish: () => setIsSearching(false),
                },
            );
        }, 300);

        return () => {
            if (timeoutRef.current !== null) {
                window.clearTimeout(timeoutRef.current);
            }
        };
    }, [query]);

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (timeoutRef.current !== null) {
            window.clearTimeout(timeoutRef.current);
        }

        lastSubmittedQueryRef.current = query;
        setIsSearching(true);

        router.get('/abfallkalender', query === '' ? {} : { q: query }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            only: ['filters', 'streets'],
            onFinish: () => setIsSearching(false),
        });
    };

    return (
        <>
            <Head title="Abfallkalender" />

            <DefaultContainer className="py-10">
                <div className="grid gap-6 lg:grid-cols-[minmax(0,22rem)_minmax(0,1fr)]">
                    <Card className="border-emerald-200 bg-linear-to-br from-emerald-50 via-white to-lime-50">
                        <CardHeader>
                            <CardTitle className="text-2xl text-zinc-950">Abfallkalender</CardTitle>
                            <CardDescription className="text-sm text-zinc-700">
                                Suche deine Straße und finde die nächsten Abfuhrtermine ohne Anmeldung.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form
                                onSubmit={handleSubmit}
                                className="space-y-3"
                            >
                                <Input
                                    type="search"
                                    value={query}
                                    onChange={(event) => setQuery(event.currentTarget.value)}
                                    placeholder="Straße suchen"
                                    aria-label="Straße suchen"
                                />
                                <Button
                                    type="submit"
                                    className="w-full bg-emerald-700 text-white hover:bg-emerald-800"
                                    disabled={isSearching}
                                >
                                    <Search className="size-4" />
                                    {isSearching ? 'Suche läuft …' : 'Suche jetzt aktualisieren'}
                                </Button>
                            </form>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Verfügbare Straßen</CardTitle>
                            <CardDescription>
                                {visibleResultQuery
                                    ? isSearching
                                        ? `Suche nach "${visibleResultQuery}" läuft …`
                                        : `Suchergebnisse für "${visibleResultQuery}"`
                                    : 'Aktuelle Straßen für das laufende Jahr'}
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            {streets.length === 0 ? (
                                <div className="rounded-xl border border-dashed border-zinc-300 bg-zinc-50 px-4 py-8 text-sm text-zinc-600">
                                    Keine Straße gefunden. Bitte passe deine Suche an.
                                </div>
                            ) : (
                                <ul className="divide-y divide-zinc-200 rounded-xl border border-zinc-200 bg-white">
                                    {streets.map((street) => (
                                        <li key={street.id}>
                                            <Link
                                                href={`/abfallkalender/${street.id}`}
                                                className="flex items-center justify-between gap-4 px-4 py-3 transition hover:bg-zinc-50"
                                            >
                                                <div>
                                                    <div className="font-medium text-zinc-950">{street.name}</div>
                                                    {street.street_addition ? (
                                                        <div className="text-sm text-zinc-500">{street.street_addition}</div>
                                                    ) : null}
                                                </div>
                                                <ArrowRight className="size-4 text-zinc-400" />
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </DefaultContainer>
        </>
    );
}

RubbishIndex.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishIndex;
