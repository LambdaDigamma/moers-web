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
        <div className={cn('relative', className)}>
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
                                    className="border-border bg-card focus-within:ring-ring/50 rounded-xl border p-2 focus-within:ring-2"
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
                                                className="text-foreground block w-full rounded-lg border-0 bg-transparent py-3 pr-12 pl-11 text-base outline-hidden"
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
                                            className="h-12 px-4"
                                        >
                                            {isLoading ? <LoaderCircle className="size-4 animate-spin" /> : <Search className="size-4" />}
                                            Finden
                                        </Button>
                                    </div>
                                </form>

                                {showResults ? (
                                    <div className="border-border bg-popover absolute inset-x-0 top-full z-30 mt-2 overflow-hidden rounded-xl border shadow-lg">
                                        {activeStreet ? (
                                            <div className="border-border bg-muted flex items-center gap-2 border-b px-4 py-3 text-sm">
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
                                                                        focus ? 'bg-muted' : 'hover:bg-muted',
                                                                    )}
                                                                >
                                                                    <div className="min-w-0">
                                                                        <div className="text-foreground truncate font-medium">{street.name}</div>
                                                                        {street.street_addition ? (
                                                                            <div className="text-muted-foreground truncate text-sm">
                                                                                {street.street_addition}
                                                                            </div>
                                                                        ) : null}
                                                                    </div>
                                                                    {isActiveStreet ? (
                                                                        <span className="bg-secondary text-secondary-foreground rounded-full px-2.5 py-1 text-xs font-medium">
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
                                                <div className="text-foreground mt-3 text-sm font-medium">Keine Straße gefunden</div>
                                                <div className="text-muted-foreground mt-1 text-sm">
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
