import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import { Link } from '@inertiajs/react';
import { Home, Star, Trash2 } from 'lucide-react';

export function PrimaryRubbishStreetCard() {
    const { primaryStreet, isLoaded, clearPrimaryStreet } = usePrimaryRubbishStreet();

    return (
        <Card className="border-zinc-200 py-0 dark:border-white/10">
            <CardHeader className="border-b border-zinc-200/80 py-6 dark:border-white/10">
                <CardTitle className="flex items-center gap-2 text-2xl">
                    <Home className="size-5 text-emerald-600" />
                    Meine Straße
                </CardTitle>
                <CardDescription>Dein persönlicher Schnellzugriff für den Abfallkalender in diesem Browser</CardDescription>
            </CardHeader>
            <CardContent className="space-y-4 py-6">
                {!isLoaded ? (
                    <div className="rounded-2xl border border-dashed border-zinc-200 px-4 py-6 text-sm text-zinc-500 dark:border-white/10 dark:text-zinc-400">
                        Lokale Auswahl wird geladen …
                    </div>
                ) : primaryStreet ? (
                    <>
                        <div className="rounded-2xl border border-emerald-200 bg-emerald-50/70 px-4 py-4 dark:border-emerald-500/20 dark:bg-emerald-500/10">
                            <div className="flex items-center gap-2 text-sm font-medium text-emerald-800 dark:text-emerald-200">
                                <Star className="size-4" />
                                Als primäre Straße gespeichert
                            </div>
                            <div className="mt-2 text-xl font-semibold text-zinc-950 dark:text-white">{primaryStreet.name}</div>
                            <div className="mt-1 text-sm text-zinc-600 dark:text-zinc-300">
                                {primaryStreet.street_addition || 'Direkter Zugriff auf die nächsten Abholtermine'}
                            </div>
                        </div>

                        <div className="flex flex-wrap gap-3">
                            <Button
                                asChild
                                className="bg-emerald-700 text-white hover:bg-emerald-800"
                            >
                                <Link href={`/abfallkalender/${primaryStreet.id}`}>Termine öffnen</Link>
                            </Button>
                            <Button
                                asChild
                                variant="outline"
                            >
                                <Link href="/abfallkalender">Andere Straße suchen</Link>
                            </Button>
                            <Button
                                type="button"
                                variant="ghost"
                                onClick={clearPrimaryStreet}
                            >
                                <Trash2 className="size-4" />
                                Auswahl löschen
                            </Button>
                        </div>
                    </>
                ) : (
                    <>
                        <p className="text-sm leading-6 text-zinc-700 dark:text-zinc-300">
                            Speichere eine Straße lokal im Browser, damit du auf der Startseite direkt zu deinem
                            Abfallkalender springen kannst.
                        </p>
                        <Button
                            asChild
                            className="bg-emerald-700 text-white hover:bg-emerald-800"
                        >
                            <Link href="/abfallkalender">Straße auswählen</Link>
                        </Button>
                    </>
                )}
            </CardContent>
        </Card>
    );
}
