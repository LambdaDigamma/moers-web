import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import { Link } from '@inertiajs/react';
import { CalendarDays, ChevronRight, Home, MapPinned, Star } from 'lucide-react';
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
        if (!primaryStreet) {
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
                if (!response.ok) {
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
                if (!abortController.signal.aborted) {
                    setIsLoadingPickups(false);
                }
            });

        return () => abortController.abort();
    }, [primaryStreet]);

    return (
        <Card className="border-zinc-200 py-0 shadow-xs dark:border-white/10">
            <CardHeader className="border-b border-zinc-100 py-4 dark:border-white/5">
                <CardTitle className="flex items-center gap-2.5 text-lg font-bold">
                    <Home className="size-4 text-emerald-600" />
                    Meine Straße
                </CardTitle>
                <CardDescription className="text-xs">Lokale Auswahl für deinen Abfallkalender</CardDescription>
            </CardHeader>
            <CardContent className="space-y-5 p-0 py-4">
                {!isLoaded ? (
                    <div className="px-5 py-4 text-xs text-zinc-500 dark:text-zinc-400">Lokale Auswahl wird geladen …</div>
                ) : primaryStreet ? (
                    <>
                        <div className="px-5">
                            <div className="flex items-center gap-1.5 text-xs font-medium tracking-wide text-emerald-700 dark:text-emerald-400">
                                <Star className="size-3 fill-current" />
                                Ausgewählt
                            </div>
                            <div className="mt-0.5 text-xl font-semibold tracking-tight text-zinc-950 dark:text-white">{primaryStreet.name}</div>
                            {primaryStreet.street_addition && (
                                <div className="text-xs text-zinc-500 dark:text-zinc-400">{primaryStreet.street_addition}</div>
                            )}
                        </div>

                        <div className="space-y-2">
                            <div className="flex items-center gap-2 px-5 text-xs font-medium tracking-wide text-zinc-400">
                                <CalendarDays className="size-3.5 text-emerald-600" />
                                Nächste Termine
                            </div>

                            {isLoadingPickups ? (
                                <div className="space-y-px divide-y divide-zinc-100 dark:divide-white/5">
                                    {[0, 1, 2].map((index) => (
                                        <div
                                            key={index}
                                            className="h-12 animate-pulse bg-zinc-50/50 dark:bg-white/5"
                                        />
                                    ))}
                                </div>
                            ) : pickupItems.length > 0 ? (
                                <div className="divide-y divide-zinc-100 border-y border-zinc-100 dark:divide-white/5 dark:border-white/5">
                                    {pickupItems.map((pickup, index) => (
                                        <div
                                            key={`${pickup.date}-${pickup.type}-${index}`}
                                            className="flex items-center justify-between gap-3 px-5 py-2.5 transition-colors hover:bg-zinc-50/50 dark:hover:bg-white/5"
                                        >
                                            <div className="text-sm font-medium text-zinc-950 dark:text-white">{formatDate(pickup.date)}</div>
                                            <div className={`shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium ${pickupMeta[pickup.type].tone}`}>
                                                {pickupMeta[pickup.type].label}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="px-5 py-4 text-xs text-zinc-500 dark:text-zinc-400">
                                    Keine kommenden Abholtermine gefunden.
                                </div>
                            )}
                        </div>

                        <div className="px-5">
                            <Link
                                href={`/abfallkalender/${primaryStreet.id}`}
                                className="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 transition hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                            >
                                Alle Termine ansehen
                                <ChevronRight className="size-3.5" />
                            </Link>
                        </div>
                    </>
                ) : (
                    <div className="px-5">
                        <div className="flex items-start gap-3 rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-500/20 dark:bg-emerald-500/5">
                            <MapPinned className="mt-0.5 size-4 shrink-0 text-emerald-600" />
                            <div className="min-w-0">
                                <div className="text-sm font-bold text-zinc-950 dark:text-white">Keine Straße gewählt</div>
                                <p className="mt-1 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400">
                                    Wähle eine Straße aus, um Abholtermine zu sehen.
                                </p>
                            </div>
                        </div>

                        <Link
                            href="/abfallkalender"
                            className="mt-4 inline-flex items-center gap-1 text-xs font-bold text-emerald-600 transition hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                        >
                            Straße auswählen
                            <ChevronRight className="size-3.5" />
                        </Link>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}
