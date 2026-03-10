import { Button } from '@/components/ui/button';
import { InputGroup } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Combobox, ComboboxInput, ComboboxOption, ComboboxOptions } from '@headlessui/react';
import { router } from '@inertiajs/react';
import { LoaderCircle, MapPinned, Search, Sparkles, X } from 'lucide-react';
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
    const [selectedStreet, setSelectedStreet] = useState<RubbishStreetListItem | null>(activeStreet);
    const [results, setResults] = useState(initialResults.slice(0, maxVisibleResults));
    const [isLoading, setIsLoading] = useState(false);
    const [isOpen, setIsOpen] = useState(autoOpen && (initialQuery.trim() !== '' || initialResults.length > 0));
    const [hasStartedSearch, setHasStartedSearch] = useState(autoOpen);
    const abortControllerRef = useRef<AbortController | null>(null);
    const closeTimeoutRef = useRef<number | null>(null);
    const activeOptionRef = useRef<RubbishStreetListItem | null>(null);
    const trimmedQuery = query.trim();
    const firstResult = results[0] ?? null;
    const showResults = isOpen && (trimmedQuery !== '' || isLoading || results.length > 0);

    useEffect(() => {
        setSelectedStreet(activeStreet);
    }, [activeStreet]);

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

    const navigateToStreet = (street: RubbishStreetListItem) => {
        setSelectedStreet(street);
        setIsOpen(false);
        router.visit(`/abfallkalender/${street.id}`);
    };

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (activeOptionRef.current) {
            navigateToStreet(activeOptionRef.current);

            return;
        }

        if (firstResult) {
            navigateToStreet(firstResult);

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
            <div className="mx-auto w-full">
                <Combobox
                    value={selectedStreet}
                    onChange={(street) => {
                        if (street) {
                            navigateToStreet(street);
                        }
                    }}
                    immediate
                    as="div"
                    className="relative"
                >
                    {({ activeOption }) => {
                        activeOptionRef.current = activeOption;

                        return (
                            <>
                                <form
                                    onSubmit={handleSubmit}
                                    onFocus={handleFocus}
                                    onBlur={handleBlur}
                                    className="rounded-[2rem] border border-zinc-200/80 bg-white/95 p-2 shadow-lg ring-1 shadow-zinc-950/8 ring-black/5 backdrop-blur dark:border-white/10 dark:bg-zinc-950/90 dark:ring-white/10"
                                >
                                    <div className="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-2">
                                        <InputGroup className="w-full">
                                            <Search
                                                data-slot="icon"
                                                className="size-5"
                                            />
                                            <ComboboxInput<RubbishStreetListItem | null>
                                                autoFocus={autoOpen}
                                                displayValue={(street) => street?.name ?? ''}
                                                onChange={(event) => {
                                                    setQuery(event.currentTarget.value);
                                                    setHasStartedSearch(true);
                                                    setIsOpen(true);

                                                    if (selectedStreet && event.currentTarget.value !== selectedStreet.name) {
                                                        setSelectedStreet(null);
                                                    }
                                                }}
                                                onKeyDown={(event) => {
                                                    if (event.key === 'Tab' && activeOptionRef.current) {
                                                        event.preventDefault();
                                                        navigateToStreet(activeOptionRef.current);
                                                    }
                                                }}
                                                placeholder="Straße suchen"
                                                aria-label="Straße suchen"
                                                className="block w-full rounded-[1.3rem] border-0 bg-transparent py-3 pr-12 pl-11 text-base text-zinc-950 ring-0 outline-hidden dark:text-white"
                                            />
                                            {query !== '' ? (
                                                <button
                                                    type="button"
                                                    onClick={() => {
                                                        setQuery('');
                                                        setSelectedStreet(null);
                                                        setResults([]);
                                                        setIsOpen(true);
                                                    }}
                                                    className="absolute top-1/2 right-3 z-10 -translate-y-1/2 rounded-full p-1 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-white/5 dark:hover:text-zinc-200"
                                                    aria-label="Suche leeren"
                                                >
                                                    <X className="size-4" />
                                                </button>
                                            ) : null}
                                        </InputGroup>

                                        <Button
                                            type="submit"
                                            size="sm"
                                            variant="outline"
                                            className="h-12 rounded-full border-zinc-200 bg-white px-4 text-zinc-700 shadow-none hover:bg-zinc-50 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200 dark:hover:bg-white/10"
                                        >
                                            {isLoading ? <LoaderCircle className="size-4 animate-spin" /> : <Search className="size-4" />}
                                            Finden
                                        </Button>
                                    </div>
                                </form>

                                {showResults ? (
                                    <div className="absolute inset-x-0 top-full mt-3 overflow-hidden rounded-3xl border border-zinc-200/80 bg-white shadow-2xl ring-1 shadow-zinc-950/10 ring-black/5 dark:border-white/10 dark:bg-zinc-950 dark:ring-white/10">
                                        {activeStreet ? (
                                            <div className="flex items-center gap-2 border-b border-zinc-200/80 bg-accent-50/80 px-4 py-3 text-sm text-accent-900 dark:border-white/10 dark:bg-accent-500/10 dark:text-accent-100">
                                                <Sparkles className="size-4" />
                                                Aktuell geöffnet: <span className="font-semibold">{activeStreet.name}</span>
                                            </div>
                                        ) : null}

                                        {results.length > 0 ? (
                                            <ComboboxOptions
                                                static
                                                className="max-h-96 overflow-y-auto py-2 outline-hidden"
                                            >
                                                {results.map((street) => {
                                                    const isActiveStreet = activeStreet?.id === street.id;

                                                    return (
                                                        <ComboboxOption
                                                            key={street.id}
                                                            value={street}
                                                            as="div"
                                                        >
                                                            {({ focus }) => (
                                                                <div
                                                                    className={cn(
                                                                        'flex cursor-pointer items-center justify-between gap-4 px-4 py-3 transition',
                                                                        focus
                                                                            ? 'bg-accent-50 dark:bg-accent-500/10'
                                                                            : 'hover:bg-zinc-50 dark:hover:bg-white/5',
                                                                    )}
                                                                >
                                                                    <div className="min-w-0">
                                                                        <div className="truncate font-medium text-zinc-950 dark:text-white">
                                                                            {street.name}
                                                                        </div>
                                                                        {street.street_addition ? (
                                                                            <div className="truncate text-sm text-zinc-500 dark:text-zinc-400">
                                                                                {street.street_addition}
                                                                            </div>
                                                                        ) : null}
                                                                    </div>
                                                                    {isActiveStreet ? (
                                                                        <span className="rounded-full bg-accent-100 px-2.5 py-1 text-xs font-medium text-accent-800 dark:bg-accent-500/15 dark:text-accent-200">
                                                                            Aktuell
                                                                        </span>
                                                                    ) : null}
                                                                </div>
                                                            )}
                                                        </ComboboxOption>
                                                    );
                                                })}
                                            </ComboboxOptions>
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
                            </>
                        );
                    }}
                </Combobox>
            </div>
        </div>
    );
}
