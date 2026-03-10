import { DefaultContainer } from '@/components/default-container';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Heading } from '@/components/ui/heading';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import {
    CategoryScale,
    Chart as ChartJS,
    Filler,
    LinearScale,
    LineElement,
    PointElement,
    Title,
    Tooltip,
} from 'chart.js';
import { format, parseISO } from 'date-fns';
import { de } from 'date-fns/locale';
import { ArrowLeft, CircleParking, MapPin, Navigation } from 'lucide-react';
import { ReactNode, useMemo } from 'react';
import { Line } from 'react-chartjs-2';
import ParkingArea = Modules.Parking.Data.ParkingArea;

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Filler
);

interface OccupancyData {
    occupancy_rate: number | string;
    hour: number;
}

interface Props {
    parkingArea: ParkingArea;
    pastOccupancy: OccupancyData[];
    imageUrl: string | null;
    googleMapsUrl: string | null;
}

const ParkingShow = ({ parkingArea, pastOccupancy, imageUrl, googleMapsUrl }: Props) => {
    const chartData = useMemo(() => {
        // Sort by hour to ensure correct line drawing
        // Note: The controller returns last 23 hours, so the order might be like 17, 18... 23, 0, 1...
        // We should probably keep the order as returned if it's already chronological from the DB.
        // In the legacy code it was grouped by hour and ordered by created_at.
        
        const labels = pastOccupancy.map(d => `${d.hour}:00`);
        const data = pastOccupancy.map(d => Number(d.occupancy_rate) * 100);

        return {
            labels,
            datasets: [
                {
                    label: 'Belegung (%)',
                    data,
                    fill: true,
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                },
            ],
        };
    }, [pastOccupancy]);

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                mode: 'index' as const,
                intersect: false,
                callbacks: {
                    label: (context: any) => `${context.parsed.y.toFixed(1)}% belegt`,
                },
            },
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: (value: any) => `${value}%`,
                    stepSize: 25,
                },
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)',
                },
            },
            x: {
                grid: {
                    display: false,
                },
            },
        },
    };

    return (
        <>
            <Head title={`${parkingArea.name} - Parken in Moers`} />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <header className="border-b border-zinc-200 bg-white dark:border-white/5 dark:bg-zinc-900/50">
                    <DefaultContainer>
                        <div className="flex flex-col gap-8 py-12 lg:flex-row lg:items-center lg:justify-between">
                            <div className="space-y-6">
                                <Button
                                    asChild
                                    variant="ghost"
                                    size="sm"
                                    className="-ml-2 text-zinc-500 hover:text-zinc-950 dark:hover:text-white"
                                >
                                    <a href={route('parking-areas.index')}>
                                        <ArrowLeft className="mr-2 size-4" />
                                        Zurück zur Übersicht
                                    </a>
                                </Button>
                                <div className="space-y-2">
                                    <div className="flex items-center gap-3">
                                        <CircleParking className="size-8 text-indigo-600" />
                                        <Heading className="text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">
                                            {parkingArea.name}
                                        </Heading>
                                    </div>
                                    <div className="flex flex-wrap items-center gap-4 text-sm text-zinc-500">
                                        <div className="flex items-center gap-1.5">
                                            <MapPin className="size-4" />
                                            Moers Innenstadt
                                        </div>
                                        <div className="flex items-center gap-1.5">
                                            <div className={`size-2 rounded-full ${parkingArea.state === 'open' ? 'bg-emerald-500' : 'bg-zinc-300'}`} />
                                            {parkingArea.state === 'open' ? 'Geöffnet' : 'Geschlossen'}
                                        </div>
                                        {parkingArea.updated_at && (
                                            <div>
                                                Zuletzt aktualisiert: {format(parseISO(parkingArea.updated_at), 'HH:mm', { locale: de })} Uhr
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {googleMapsUrl && (
                                <Button
                                    asChild
                                    size="lg"
                                    className="rounded-2xl bg-indigo-600 px-8 text-white shadow-xl shadow-indigo-500/20 hover:bg-indigo-700"
                                >
                                    <a href={googleMapsUrl} target="_blank" rel="noopener noreferrer">
                                        <Navigation className="mr-2 size-5" />
                                        Navigation starten
                                    </a>
                                </Button>
                            )}
                        </div>
                    </DefaultContainer>
                </header>

                <DefaultContainer className="py-12">
                    <div className="grid gap-8 lg:grid-cols-3">
                        {/* Status Card */}
                        <Card className="border-zinc-200 bg-white shadow-sm dark:border-white/5 dark:bg-zinc-900">
                            <CardHeader>
                                <CardTitle className="text-lg font-bold">Aktuelle Belegung</CardTitle>
                                <CardDescription>Verfügbare Parkplätze in Echtzeit</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="flex flex-col items-center justify-center rounded-3xl bg-zinc-50 py-12 dark:bg-white/5">
                                    <div className={`text-7xl font-black tracking-tighter tabular-nums ${
                                        parkingArea.capacity && parkingArea.occupied && parkingArea.capacity - parkingArea.occupied < 10
                                            ? 'text-amber-500'
                                            : 'text-zinc-950 dark:text-white'
                                    }`}>
                                        {parkingArea.capacity ? Math.max(0, parkingArea.capacity - parkingArea.occupied!) : '—'}
                                    </div>
                                    <div className="mt-2 text-sm font-bold text-zinc-500 uppercase tracking-widest">
                                        Freie Plätze
                                    </div>
                                </div>

                                <div className="space-y-4">
                                    <div className="flex items-center justify-between text-sm">
                                        <span className="text-zinc-500">Gesamtkapazität</span>
                                        <span className="font-bold text-zinc-950 dark:text-white">{parkingArea.capacity ?? 'Unbekannt'}</span>
                                    </div>
                                    <div className="flex items-center justify-between text-sm">
                                        <span className="text-zinc-500">Belegte Plätze</span>
                                        <span className="font-bold text-zinc-950 dark:text-white">{parkingArea.occupied ?? 'Unbekannt'}</span>
                                    </div>
                                    <div className="pt-4">
                                        <div className="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider">
                                            <span className="text-zinc-400">Auslastung</span>
                                            <span className="text-indigo-600 dark:text-indigo-400">
                                                {parkingArea.capacity && parkingArea.occupied 
                                                    ? Math.round((parkingArea.occupied / parkingArea.capacity) * 100) 
                                                    : 0}%
                                            </span>
                                        </div>
                                        <div className="h-2 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-white/10">
                                            <div 
                                                className="h-full bg-indigo-600 transition-all duration-500" 
                                                style={{ 
                                                    width: `${parkingArea.capacity && parkingArea.occupied 
                                                        ? Math.min(100, (parkingArea.occupied / parkingArea.capacity) * 100) 
                                                        : 0}%` 
                                                }} 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Chart Card */}
                        <Card className="border-zinc-200 bg-white shadow-sm lg:col-span-2 dark:border-white/5 dark:bg-zinc-900">
                            <CardHeader>
                                <CardTitle className="text-lg font-bold">Historische Auslastung</CardTitle>
                                <CardDescription>Durchschnittliche Belegung der letzten 24 Stunden</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="h-[300px] w-full pt-4">
                                    {pastOccupancy.length > 0 ? (
                                        <Line data={chartData} options={chartOptions} />
                                    ) : (
                                        <div className="flex h-full items-center justify-center text-sm text-zinc-500 italic">
                                            Keine historischen Daten verfügbar
                                        </div>
                                    )}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Map Card */}
                        {imageUrl && (
                            <Card className="overflow-hidden border-zinc-200 bg-white shadow-sm lg:col-span-3 dark:border-white/5 dark:bg-zinc-900">
                                <CardHeader>
                                    <CardTitle className="text-lg font-bold">Standort</CardTitle>
                                </CardHeader>
                                <CardContent className="p-0">
                                    <div className="aspect-video w-full overflow-hidden md:aspect-[21/9]">
                                        <img 
                                            src={imageUrl} 
                                            alt={`Standort von ${parkingArea.name}`} 
                                            className="h-full w-full object-cover"
                                        />
                                    </div>
                                </CardContent>
                            </Card>
                        )}
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
};

ParkingShow.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ParkingShow;
