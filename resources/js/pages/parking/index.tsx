import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { ArrowRight, CircleParking } from 'lucide-react';
import { ReactNode } from 'react';
import ParkingArea = Modules.Parking.Data.ParkingArea;

interface Props {
    parkingAreas: ParkingArea[];
}

const ParkingIndex = ({ parkingAreas }: Props) => {
    return (
        <>
            <Head title="Parken in Moers" />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <PageHeader
                    badge={
                        <div className="flex items-center gap-2">
                            <CircleParking className="size-3.5" />
                            Echtzeit-Parkdaten
                        </div>
                    }
                    title="Parken in Moers"
                    description="Finden Sie freie Parkplätze in der Moerser Innenstadt. Wir zeigen Ihnen die aktuelle Belegung und Öffnungszeiten der wichtigsten Parkhäuser und Parkplätze."
                />

                <DefaultContainer className="py-12">
                    <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {parkingAreas.map((area) => (
                            <Link
                                key={area.id}
                                href={route('parking-areas.show', [area.slug])}
                                className="group"
                            >
                                <Card className="h-full border-zinc-200 bg-white transition-all hover:-translate-y-1 hover:shadow-lg dark:border-white/5 dark:bg-zinc-900">
                                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-4">
                                        <CardTitle className="text-xl font-bold text-zinc-950 dark:text-white">{area.name}</CardTitle>
                                        <Badge
                                            className={
                                                area.state === 'open'
                                                    ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400'
                                                    : 'bg-zinc-100 text-zinc-600 dark:bg-white/5 dark:text-zinc-400'
                                            }
                                            variant="outline"
                                        >
                                            <span
                                                className={`mr-1.5 size-1.5 rounded-full ${area.state === 'open' ? 'bg-emerald-500' : 'bg-zinc-400'}`}
                                            />
                                            {area.state === 'open' ? 'Geöffnet' : 'Geschlossen'}
                                        </Badge>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="flex items-baseline gap-2">
                                            <div
                                                className={`text-4xl font-black tracking-tighter tabular-nums ${
                                                    area.capacity && area.occupied && area.capacity - area.occupied < 10
                                                        ? 'text-amber-500'
                                                        : 'text-zinc-950 dark:text-white'
                                                }`}
                                            >
                                                {area.capacity ? Math.max(0, area.capacity - area.occupied!) : '—'}
                                            </div>
                                            <div className="text-sm font-bold text-zinc-500">/ {area.capacity ?? '—'} frei</div>
                                        </div>

                                        <div className="mt-6 flex items-center justify-between text-sm">
                                            <div className="text-zinc-500">Details & Historie</div>
                                            <ArrowRight className="size-4 text-zinc-400 transition-transform group-hover:translate-x-1" />
                                        </div>
                                    </CardContent>
                                </Card>
                            </Link>
                        ))}
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
};

ParkingIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ParkingIndex;
