import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Empty, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { ArrowRight, CircleParking } from 'lucide-react';
import { ReactNode } from 'react';
import ParkingArea = Modules.Parking.Data.ParkingArea;

const ParkingIndex = ({ parkingAreas }: { parkingAreas: ParkingArea[] }) => (
    <>
        <SeoHead
            title="Parken in Moers"
            description="Finde freie Parkplätze in Moers und sieh die aktuelle Belegung der wichtigsten Parkhäuser in der Innenstadt."
        />
        <PageHeader
            badge="Parkhäuser live"
            title="Parken in Moers"
            description="Freie Plätze, Öffnungsstatus und aktuelle Belegung der Parkhäuser in der Innenstadt auf einen Blick."
        />
        <DefaultContainer className="py-12 md:py-16">
            {parkingAreas.length === 0 ? (
                <Empty>
                    <EmptyHeader>
                        <EmptyMedia variant="icon">
                            <CircleParking />
                        </EmptyMedia>
                        <EmptyTitle>Keine Parkdaten verfügbar</EmptyTitle>
                        <EmptyDescription>Aktuell liegen keine Informationen zu den Parkhäusern vor.</EmptyDescription>
                    </EmptyHeader>
                </Empty>
            ) : (
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {parkingAreas.map((area) => {
                        const freeSpaces = area.capacity === null ? null : Math.max(0, area.capacity - (area.occupied ?? 0));
                        const occupancy = area.capacity ? Math.min(100, ((area.occupied ?? 0) / area.capacity) * 100) : 0;
                        const isOpen = area.state === 'open';
                        const almostFull = isOpen && occupancy > 90;
                        return (
                            <Link
                                key={area.id}
                                href={route('parking-areas.show', [area.slug])}
                                className="group focus-visible:outline-ring rounded-xl focus-visible:outline-2 focus-visible:outline-offset-4"
                            >
                                <Card className="group-hover:bg-muted h-full gap-5 shadow-none transition-colors">
                                    <CardHeader className="gap-2">
                                        <div className="flex items-start justify-between gap-3">
                                            <CardTitle>
                                                <h2 className="font-display tracking-title text-xl leading-snug">{area.name}</h2>
                                            </CardTitle>
                                            <Badge variant="outline">
                                                <span className={cn('size-1.5 rounded-full', isOpen ? 'bg-success' : 'bg-muted-foreground')} />
                                                {isOpen ? 'Offen' : 'Geschlossen'}
                                            </Badge>
                                        </div>
                                        <CardDescription>Moers Innenstadt</CardDescription>
                                    </CardHeader>
                                    <CardContent className="flex flex-col gap-4">
                                        <div className="flex items-baseline gap-2">
                                            <span
                                                className={cn(
                                                    'font-display tracking-heading text-4xl font-semibold tabular-nums',
                                                    almostFull && 'text-warning',
                                                )}
                                            >
                                                {isOpen ? (freeSpaces ?? '–') : '–'}
                                            </span>
                                            <span className="text-muted-foreground text-sm">von {area.capacity ?? '–'} Plätzen frei</span>
                                        </div>
                                        <div className="bg-secondary h-1 overflow-hidden rounded-sm">
                                            <div
                                                className={cn('h-full', almostFull ? 'bg-warning' : 'bg-foreground')}
                                                style={{ width: `${isOpen ? occupancy : 0}%` }}
                                            />
                                        </div>
                                    </CardContent>
                                    <CardFooter className="mt-auto justify-between text-sm font-semibold">
                                        Details und Verlauf
                                        <ArrowRight className="text-muted-foreground size-4 transition-transform group-hover:translate-x-0.5" />
                                    </CardFooter>
                                </Card>
                            </Link>
                        );
                    })}
                </div>
            )}
        </DefaultContainer>
    </>
);

ParkingIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;
export default ParkingIndex;
