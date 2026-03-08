import { DefaultContainer } from '@/components/default-container';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { CalendarDays, Download, FileText, Leaf, Recycle, Trash2 } from 'lucide-react';
import { ReactNode } from 'react';

type PickupItem = {
    date: string;
    type: 'organic' | 'paper' | 'residual' | 'plastic' | 'cuttings';
};

type PickupGroup = {
    date: string;
    items: PickupItem[];
};

type RubbishShowProps = {
    street: {
        id: number;
        name: string;
        street_addition: string | null;
    };
    pickupGroups: PickupGroup[];
    downloads: {
        ics_url: string;
        pdf_url: string;
    };
};

const pickupMeta: Record<PickupItem['type'], { label: string; icon: typeof Trash2; tone: string }> = {
    residual: {
        label: 'Restmüll',
        icon: Trash2,
        tone: 'bg-zinc-900 text-white',
    },
    organic: {
        label: 'Biotonne',
        icon: Leaf,
        tone: 'bg-emerald-600 text-white',
    },
    paper: {
        label: 'Papier',
        icon: FileText,
        tone: 'bg-sky-600 text-white',
    },
    plastic: {
        label: 'Gelber Sack',
        icon: Recycle,
        tone: 'bg-amber-400 text-zinc-950',
    },
    cuttings: {
        label: 'Grünschnitt',
        icon: Leaf,
        tone: 'bg-lime-600 text-white',
    },
};

function formatDate(date: string): string {
    return new Intl.DateTimeFormat('de-DE', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(date));
}

function RubbishShow({ street, pickupGroups, downloads }: RubbishShowProps) {
    return (
        <>
            <Head title={`Abfallkalender ${street.name}`} />

            <DefaultContainer className="py-10">
                <div className="space-y-6">
                    <Card className="border-emerald-200 bg-linear-to-r from-emerald-50 via-white to-lime-50">
                        <CardHeader className="gap-4 md:flex-row md:items-start md:justify-between">
                            <div className="space-y-2">
                                <Link
                                    href="/abfallkalender"
                                    className="text-sm font-medium text-emerald-700 hover:text-emerald-800"
                                >
                                    Zurück zur Suche
                                </Link>
                                <div>
                                    <CardTitle className="text-3xl text-zinc-950">{street.name}</CardTitle>
                                    <CardDescription className="mt-1 text-base text-zinc-700">
                                        {street.street_addition || 'Nächste Abfuhrtermine für diese Straße'}
                                    </CardDescription>
                                </div>
                            </div>

                            <div className="flex flex-wrap gap-3">
                                <Button
                                    asChild
                                    variant="outline"
                                >
                                    <a
                                        href={downloads.ics_url}
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        <CalendarDays className="size-4" />
                                        Kalender
                                    </a>
                                </Button>
                                <Button
                                    asChild
                                    className="bg-emerald-700 text-white hover:bg-emerald-800"
                                >
                                    <a
                                        href={downloads.pdf_url}
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        <Download className="size-4" />
                                        PDF laden
                                    </a>
                                </Button>
                            </div>
                        </CardHeader>
                    </Card>

                    {pickupGroups.length === 0 ? (
                        <Card>
                            <CardContent className="py-8 text-sm text-zinc-600">
                                Für diese Straße sind aktuell keine kommenden Termine hinterlegt.
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="space-y-4">
                            {pickupGroups.map((group) => (
                                <Card key={group.date}>
                                    <CardHeader>
                                        <CardTitle className="text-lg">{formatDate(group.date)}</CardTitle>
                                        <CardDescription>Geplante Leerungen an diesem Tag</CardDescription>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                            {group.items.map((item, index) => {
                                                const meta = pickupMeta[item.type];
                                                const Icon = meta.icon;

                                                return (
                                                    <div
                                                        key={`${group.date}-${item.type}-${index}`}
                                                        className="flex items-center gap-3 rounded-xl border border-zinc-200 px-4 py-3"
                                                    >
                                                        <div className={`flex size-10 items-center justify-center rounded-full ${meta.tone}`}>
                                                            <Icon className="size-4" />
                                                        </div>
                                                        <div>
                                                            <div className="font-medium text-zinc-950">{meta.label}</div>
                                                            <div className="text-sm text-zinc-500">Abholung geplant</div>
                                                        </div>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}
                </div>
            </DefaultContainer>
        </>
    );
}

RubbishShow.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishShow;
