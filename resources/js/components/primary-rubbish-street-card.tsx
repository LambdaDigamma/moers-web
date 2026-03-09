import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import { Link } from '@inertiajs/react';
import { CalendarDays, ChevronRight, FileText, Home, Leaf, MapPinned, Recycle, Star, Trash2 } from 'lucide-react';
import { useEffect, useState } from 'react';

type PickupItem = {
    date: string;
    type: 'organic' | 'paper' | 'residual' | 'plastic' | 'cuttings';
};

const pickupMeta: Record<PickupItem['type'], { label: string; tone: string }> = {
    residual: {
        label: 'Restmüll',
        tone: 'bg-zinc-950 text-white dark:bg-zinc-100 dark:text-zinc-950',
    },
    organic: {
        label: 'Biotonne',
        tone: 'bg-emerald-600 text-white',
    },
    paper: {
        label: 'Papier',
        tone: 'bg-sky-600 text-white',
    },
    plastic: {
        label: 'Gelber Sack',
        tone: 'bg-amber-300 text-zinc-950',
    },
    cuttings: {
        label: 'Grünschnitt',
        tone: 'bg-lime-600 text-white',
    },
};

const formatDate = (value: string) =>
    new Intl.DateTimeFormat('de-DE', {
        weekday: 'short',
        day: '2-digit',
        month: '2-digit',
    }).format(new Date(value));

export function PrimaryRubbishStreetCard() {
    const { primaryStreet, isLoaded } = usePrimaryRubbishStreet();
    const [pickupItems, setPickupItems] = useState<PickupItem[]>([]);
    const [isLoadingPickups, setIsLoadingPickups] = useState(false);

    useEffect(() => {
        if (! primaryStreet) {
            setPickupItems([]);

            return;
        }

        const abortController = new AbortController();

        setIsLoadingPickups(true);

        fetch(`/api/v1/rubbish/streets/${primaryStreet.id}/pickups`, {
            signal: abortController.signal,
            headers: {
                Accept: 'application/json',
            },
        })
            .then(async (response) => {
                if (! response.ok) {
                    throw new Error('Unable to load pickups');
                }

                const payload = (await response.json()) as { data?: PickupItem[] };

                setPickupItems((payload.data ?? []).slice(0, 4));
            })
            .catch((error: unknown) => {
                if (error instanceof DOMException && error.name === 'AbortError') {
                    return;
                }

                setPickupItems([]);
            })
            .finally(() => {
                if (! abortController.signal.aborted) {
                    setIsLoadingPickups(false);
                }
            });

        return () => abortController.abort();
    }, [primaryStreet]);

    return (
        <Card className="border-zinc-200 py-0 dark:border-white/10">
            <CardHeader className="border-b border-zinc-200/80 py-5 dark:border-white/10">
                <CardTitle className="flex items-center gap-2 text-xl">
                    <Home className="size-4.5 text-emerald-600" />
                    Meine Straße
                </CardTitle>
                <CardDescription>Lokale Auswahl für deinen Abfallkalender</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4 py-5">
                {!isLoaded ? (
                    <div className="rounded-2xl border border-dashed border-zinc-200 px-4 py-6 text-sm text-zinc-500 dark:border-white/10 dark:text-zinc-400">
                        Lokale Auswahl wird geladen …
                    </div>
                ) : primaryStreet ? (
                    <>
                        <div className="rounded-2xl border border-emerald-200 bg-linear-to-r from-emerald-50 to-emerald-100/50 px-4 py-3.5 dark:border-emerald-500/20 dark:from-emerald-500/10 dark:to-emerald-500/5">
                            <div className="flex items-center gap-2 text-xs font-medium tracking-[0.16em] text-emerald-800 uppercase dark:text-emerald-200">
                                <Star className="size-4" />
                                Ausgewählt
                            </div>
                            <div className="mt-1.5 text-2xl font-semibold tracking-tight text-zinc-950 dark:text-white">{primaryStreet.name}</div>
                            {primaryStreet.street_addition ? (
                                <div className="mt-1 text-sm text-zinc-600 dark:text-zinc-300">{primaryStreet.street_addition}</div>
                            ) : null}
                        </div>

                        <div className="space-y-3">
                            <div className="flex items-center gap-2 text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                <CalendarDays className="size-4 text-emerald-600" />
                                Nächste Termine
                            </div>

                            {isLoadingPickups ? (
                                <div className="space-y-2">
                                    {[0, 1, 2].map((index) => (
                                        <div
                                            key={index}
                                            className="h-16 animate-pulse rounded-2xl bg-zinc-100 dark:bg-white/5"
                                        />
                                    ))}
                                </div>
                            ) : pickupItems.length > 0 ? (
                                <div className="space-y-2">
                                    {pickupItems.map((pickup, index) => (
                                        <div
                                            key={`${pickup.date}-${pickup.type}-${index}`}
                                            className="flex items-center justify-between gap-3 rounded-xl border border-zinc-200 px-3.5 py-2.5 dark:border-white/10"
                                        >
                                            <div className="min-w-0">
                                                <div className="text-sm font-medium text-zinc-950 dark:text-white">{formatDate(pickup.date)}</div>
                                                <div className="mt-0.5 flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                                                    {pickup.type === 'organic' || pickup.type === 'cuttings' ? (
                                                        <Leaf className="size-4" />
                                                    ) : pickup.type === 'paper' ? (
                                                        <FileText className="size-4" />
                                                    ) : pickup.type === 'plastic' ? (
                                                        <Recycle className="size-4" />
                                                    ) : (
                                                        <Trash2 className="size-4" />
                                                    )}
                                                </div>
                                            </div>
                                            <div className={`shrink-0 rounded-full px-2.5 py-1 text-xs font-medium ${pickupMeta[pickup.type].tone}`}>
                                                {pickupMeta[pickup.type].label}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="rounded-xl border border-dashed border-zinc-200 px-4 py-4 text-sm text-zinc-500 dark:border-white/10 dark:text-zinc-400">
                                    Aktuell konnten keine kommenden Abholtermine geladen werden.
                                </div>
                            )}
                        </div>

                        <div>
                            <Link
                                href={`/abfallkalender/${primaryStreet.id}`}
                                className="inline-flex items-center gap-1 text-sm font-medium text-emerald-700 transition hover:text-emerald-800 dark:text-emerald-300 dark:hover:text-emerald-200"
                            >
                                Alle Termine ansehen
                                <ChevronRight className="size-4" />
                            </Link>
                        </div>
                    </>
                ) : (
                    <div className="rounded-2xl border border-dashed border-emerald-200 bg-linear-to-br from-emerald-50/80 via-white to-lime-50/70 px-4 py-5 dark:border-emerald-500/20 dark:from-emerald-500/10 dark:via-transparent dark:to-lime-500/5">
                        <div className="flex items-start gap-3">
                            <div className="flex size-10 shrink-0 items-center justify-center rounded-full bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200 dark:bg-white/10 dark:text-emerald-200 dark:ring-emerald-500/20">
                                <MapPinned className="size-5" />
                            </div>
                            <div className="min-w-0">
                                <div className="text-sm font-medium text-zinc-950 dark:text-white">Noch keine Straße gewählt</div>
                                <p className="mt-1 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                    Wähle eine Straße aus und sie erscheint hier künftig mit den nächsten Abholterminen.
                                </p>
                            </div>
                        </div>

                        <Link
                            href="/abfallkalender"
                            className="mt-4 inline-flex items-center gap-1 text-sm font-medium text-emerald-700 transition hover:text-emerald-800 dark:text-emerald-300 dark:hover:text-emerald-200"
                        >
                            Straße auswählen
                            <ChevronRight className="size-4" />
                        </Link>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}
