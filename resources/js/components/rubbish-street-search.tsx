import { Button } from '@/components/ui/button';
import { Input, InputGroup } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Link, router } from '@inertiajs/react';
import { LoaderCircle, MapPinned, Search, Sparkles } from 'lucide-react';
import { FormEvent, useEffect, useRef, useState } from 'react';

type RubbishStreetListItem = {
    id: number;
    name: string;
    street_addition: string | null;
};

type RubbishStreetSearchProps = {
    initialQuery?: string;
    initialResults?: RubbishStreetListItem[];
    activeStreet?: RubbishStreetListItem | null;
    autoOpen?: boolean;
    className?: string;
};

const maxVisibleResults = 8;

export function RubbishStreetSearch({
    initialQuery = '',
    initialResults = [],
    activeStreet = null,
    autoOpen = false,
    className,
}: RubbishStreetSearchProps) {
    const [query, setQuery] = useState(initialQuery);
    const [results, setResults] = useState(initialResults.slice(0, maxVisibleResults));
    const [isLoading, setIsLoading] = useState(false);
    const [isOpen, setIsOpen] = useState(autoOpen && (initialQuery.trim() !== '' || initialResults.length > 0));
    const [hasStartedSearch, setHasStartedSearch] = useState(autoOpen);
    const abortControllerRef = useRef<AbortController | null>(null);
    const closeTimeoutRef = useRef<number | null>(null);
    const trimmedQuery = query.trim();
    const firstResult = results[0] ?? null;
    const showResults = isOpen && (trimmedQuery !== '' || isLoading || results.length > 0);

    useEffect(() => {
        if (!hasStartedSearch) {
            return;
        }

        if (trimmedQuery === '') {
            abortControllerRef.current?.abort();
            setIsLoading(false);
            setResults([]);

            return;
        }

        const abortController = new AbortController();
        abortControllerRef.current?.abort();
        abortControllerRef.current = abortController;
        setIsLoading(true);

        const timeoutId = window.setTimeout(() => {
            fetch(`/api/v1/rubbish/streets?q=${encodeURIComponent(trimmedQuery)}`, {
                signal: abortController.signal,
                headers: {
                    Accept: 'application/json',
                },
            })
                .then(async (response) => {
                    if (!response.ok) {
                        throw new Error('Unable to load streets');
                    }

                    const payload = (await response.json()) as { data?: RubbishStreetListItem[] };

                    setResults((payload.data ?? []).slice(0, maxVisibleResults));
                    setIsOpen(true);
                })
                .catch((error: unknown) => {
                    if (error instanceof DOMException && error.name === 'AbortError') {
                        return;
                    }

                    setResults([]);
                })
                .finally(() => {
                    if (!abortController.signal.aborted) {
                        setIsLoading(false);
                    }
                });
        }, 220);

        return () => {
            window.clearTimeout(timeoutId);
            abortController.abort();
        };
    }, [hasStartedSearch, trimmedQuery]);

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (firstResult) {
            router.visit(`/abfallkalender/${firstResult.id}`);

            return;
        }

        router.get('/abfallkalender', trimmedQuery === '' ? {} : { q: trimmedQuery });
    };

    const handleFocus = () => {
        if (closeTimeoutRef.current !== null) {
            window.clearTimeout(closeTimeoutRef.current);
        }

        setHasStartedSearch(true);
        setIsOpen(true);
    };

    const handleBlur = () => {
        closeTimeoutRef.current = window.setTimeout(() => {
            setIsOpen(false);
        }, 120);
    };

    return (
        <div className={cn('sticky top-4 z-30', className)}>
            <div className="mx-auto max-w-3xl">
                <div className="relative">
                    <form
                        onSubmit={handleSubmit}
                        onFocus={handleFocus}
                        onBlur={handleBlur}
                        className="rounded-[2rem] border border-zinc-200/80 bg-white/95 p-2 shadow-lg shadow-zinc-950/8 ring-1 ring-black/5 backdrop-blur dark:border-white/10 dark:bg-zinc-950/90 dark:ring-white/10"
                    >
                        <div className="flex items-center gap-2">
                            <InputGroup className="flex-1">
                                <Search data-slot="icon" className="size-5" />
                                <Input
                                    type="search"
                                    value={query}
                                    onChange={(event) => {
                                        setQuery(event.currentTarget.value);
                                        setHasStartedSearch(true);
                                        setIsOpen(true);
                                    }}
                                    placeholder="Straße suchen"
                                    aria-label="Straße suchen"
                                    className="border-0 text-base shadow-none before:hidden after:hidden"
                                />
                            </InputGroup>

                            <Button
                                type="submit"
                                size="sm"
                                className="rounded-full bg-emerald-700 px-4 text-white hover:bg-emerald-800"
                            >
                                {isLoading ? <LoaderCircle className="size-4 animate-spin" /> : <Search className="size-4" />}
                                Finden
                            </Button>
                        </div>
                    </form>

                    {showResults ? (
                        <div className="absolute inset-x-0 top-full mt-3 overflow-hidden rounded-3xl border border-zinc-200/80 bg-white shadow-2xl shadow-zinc-950/10 ring-1 ring-black/5 dark:border-white/10 dark:bg-zinc-950 dark:ring-white/10">
                            {activeStreet ? (
                                <div className="flex items-center gap-2 border-b border-zinc-200/80 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-900 dark:border-white/10 dark:bg-emerald-500/10 dark:text-emerald-100">
                                    <Sparkles className="size-4" />
                                    Aktuell geöffnet: <span className="font-semibold">{activeStreet.name}</span>
                                </div>
                            ) : null}

                            {results.length > 0 ? (
                                <div className="max-h-96 overflow-y-auto py-2">
                                    {results.map((street) => {
                                        const isActiveStreet = activeStreet?.id === street.id;

                                        return (
                                            <Link
                                                key={street.id}
                                                href={`/abfallkalender/${street.id}`}
                                                className="flex items-center justify-between gap-4 px-4 py-3 transition hover:bg-zinc-50 dark:hover:bg-white/5"
                                            >
                                                <div className="min-w-0">
                                                    <div className="truncate font-medium text-zinc-950 dark:text-white">{street.name}</div>
                                                    {street.street_addition ? (
                                                        <div className="truncate text-sm text-zinc-500 dark:text-zinc-400">{street.street_addition}</div>
                                                    ) : null}
                                                </div>
                                                {isActiveStreet ? (
                                                    <span className="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-200">
                                                        Aktuell
                                                    </span>
                                                ) : null}
                                            </Link>
                                        );
                                    })}
                                </div>
                            ) : (
                                <div className="px-4 py-8 text-center">
                                    <div className="mx-auto flex size-11 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 dark:bg-white/5 dark:text-zinc-400">
                                        <MapPinned className="size-5" />
                                    </div>
                                    <div className="mt-3 text-sm font-medium text-zinc-950 dark:text-white">Keine Straße gefunden</div>
                                    <div className="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        Prüfe die Schreibweise oder versuche einen anderen Straßennamen.
                                    </div>
                                </div>
                            )}
                        </div>
                    ) : null}
                </div>
            </div>
        </div>
    );
}
