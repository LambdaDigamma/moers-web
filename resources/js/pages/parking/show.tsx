import { DefaultContainer } from '@/components/default-container';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Heading } from '@/components/ui/heading';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
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
import { motion } from 'framer-motion';
import { ArrowLeft, CircleParking, ExternalLink, Info, MapPin, Navigation, TrendingUp } from 'lucide-react';
import { ReactNode, useMemo } from 'react';
import { Line } from 'react-chartjs-2';
import ParkingArea = Modules.Parking.Data.ParkingArea;

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Filler);

interface OccupancyData {
    occupancy_rate: number | string;
    hour: number;
    hour_timestamp: string;
}

interface Props {
    parkingArea: ParkingArea;
    pastOccupancy: OccupancyData[];
    imageUrl: string | null;
    googleMapsUrl: string | null;
    lat: number | null;
    lng: number | null;
}

const ParkingShow = ({ parkingArea, pastOccupancy, imageUrl, googleMapsUrl, lat, lng }: Props) => {
    const freeSites = useMemo(() => {
        if (parkingArea.capacity === null || parkingArea.occupied === null) return null;
        return Math.max(0, parkingArea.capacity - parkingArea.occupied);
    }, [parkingArea]);

    const occupancyPercentage = useMemo(() => {
        if (!parkingArea.capacity || parkingArea.occupied === null) return 0;
        return Math.min(100, Math.round((parkingArea.occupied / parkingArea.capacity) * 100));
    }, [parkingArea]);

    const chartData = useMemo(() => {
        const labels = pastOccupancy.map((d) => `${String(d.hour).padStart(2, '0')}:00`);
        const data = pastOccupancy.map((d) => Number(d.occupancy_rate) * 100);

        return {
            labels,
            datasets: [
                {
                    label: 'Belegung',
                    data,
                    fill: true,
                    borderColor: 'rgb(217, 119, 6)', // Amber-600
                    borderWidth: 2,
                    backgroundColor: (context: any) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0, 'rgba(245, 158, 11, 0.1)'); // Amber-500
                        gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
                        return gradient;
                    },
                    tension: 0.3,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: 'rgb(217, 119, 6)', // Amber-600
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                },
            ],
        };
    }, [pastOccupancy]);

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index' as const,
        },
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                titleColor: '#18181b',
                bodyColor: '#18181b',
                borderColor: '#e4e4e7',
                borderWidth: 1,
                padding: 10,
                boxPadding: 4,
                usePointStyle: true,
                callbacks: {
                    label: (context: any) => ` ${context.parsed.y.toFixed(1)}% belegt`,
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
                    font: { size: 10 },
                    color: '#71717a',
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.04)',
                    drawBorder: false,
                },
            },
            x: {
                ticks: {
                    font: { size: 10 },
                    color: '#71717a',
                    maxRotation: 0,
                    autoSkip: true,
                    maxTicksLimit: 8,
                },
                grid: {
                    display: false,
                },
            },
        },
    };

    return (
        <>
            <Head title={`${parkingArea.name} - Parken in Moers`} />

            <div className="min-h-screen bg-[#FDFDFC] dark:bg-zinc-950">
                {/* Header Section */}
                <div className="relative overflow-hidden border-b border-zinc-200 bg-white pt-6 pb-10 dark:border-white/5 dark:bg-zinc-900/50">
                    <DefaultContainer className="relative">
                        <motion.div
                            initial={{ opacity: 0, y: -5 }}
                            animate={{ opacity: 1, y: 0 }}
                            className="mb-6"
                        >
                            <Button
                                asChild
                                variant="ghost"
                                size="sm"
                                className="-ml-2 h-8 text-zinc-500 hover:text-accent-600 dark:hover:text-accent-400"
                            >
                                <Link href={route('parking-areas.index')}>
                                    <ArrowLeft className="mr-1.5 size-4" />
                                    Zurück zur Übersicht
                                </Link>
                            </Button>
                        </motion.div>

                        <div className="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                            <motion.div
                                initial={{ opacity: 0, x: -10 }}
                                animate={{ opacity: 1, x: 0 }}
                                transition={{ delay: 0.1 }}
                                className="space-y-3"
                            >
                                <div className="flex items-center gap-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-accent-600 text-white shadow-sm">
                                        <CircleParking className="size-6" />
                                    </div>
                                    <div>
                                        <Heading className="text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl dark:text-white">
                                            {parkingArea.name}
                                        </Heading>
                                        <div className="flex flex-wrap items-center gap-3 mt-0.5 text-sm text-zinc-500">
                                            <div className="flex items-center gap-1.5">
                                                <MapPin className="size-3.5 text-accent-600" />
                                                Moers Innenstadt
                                            </div>
                                            <div className="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-700" />
                                            <div className="flex items-center gap-1.5 font-medium">
                                                <div
                                                    className={`size-1.5 rounded-full ${parkingArea.state === 'open' ? 'bg-accent-500' : 'bg-zinc-300'}`}
                                                />
                                                {parkingArea.state === 'open' ? 'Jetzt geöffnet' : 'Aktuell geschlossen'}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </motion.div>

                            <motion.div
                                initial={{ opacity: 0, x: 10 }}
                                animate={{ opacity: 1, x: 0 }}
                                transition={{ delay: 0.2 }}
                                className="flex flex-wrap gap-3"
                            >
                                {googleMapsUrl && (
                                    <Button
                                        asChild
                                        size="default"
                                        className="rounded-xl bg-accent-600 font-bold text-white shadow-sm hover:bg-accent-700"
                                    >
                                        <a
                                            href={googleMapsUrl}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <Navigation className="mr-1.5 size-4" />
                                            Navigation
                                        </a>
                                    </Button>
                                )}
                            </motion.div>
                        </div>
                    </DefaultContainer>
                </div>

                <DefaultContainer className="py-10">
                    <div className="grid gap-6 lg:grid-cols-3">
                        {/* Main Status Column */}
                        <div className="space-y-6 lg:col-span-1">
                            <motion.div
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ delay: 0.3 }}
                            >
                                <Card className="overflow-hidden border-zinc-200 bg-white py-0 shadow-xs dark:border-white/10 dark:bg-zinc-900">
                                    <CardHeader className="border-b border-zinc-100 py-4 dark:border-white/5">
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-base font-bold">Verfügbarkeit</CardTitle>
                                            <Badge variant="outline" className="h-5 bg-zinc-50 px-2 text-[10px] font-bold uppercase tracking-wider dark:bg-zinc-800">Live</Badge>
                                        </div>
                                    </CardHeader>
                                    <CardContent className="p-6">
                                        <div className="flex flex-col items-center justify-center py-4">
                                            <div className="relative h-40 w-40">
                                                <svg className="h-full w-full" viewBox="0 0 100 100">
                                                    <circle
                                                        className="text-zinc-100 stroke-current dark:text-zinc-800"
                                                        strokeWidth="6"
                                                        fill="transparent"
                                                        r="44"
                                                        cx="50"
                                                        cy="50"
                                                    />
                                                    <motion.circle
                                                        className="text-accent-600 stroke-current"
                                                        strokeWidth="6"
                                                        strokeLinecap="round"
                                                        fill="transparent"
                                                        r="44"
                                                        cx="50"
                                                        cy="50"
                                                        initial={{ strokeDasharray: "0 277" }}
                                                        animate={{ strokeDasharray: `${(occupancyPercentage * 277) / 100} 277` }}
                                                        transition={{ duration: 1, ease: "easeOut" }}
                                                        style={{ transform: 'rotate(-90deg)', transformOrigin: '50% 50%' }}
                                                    />
                                                </svg>
                                                <div className="absolute inset-0 flex flex-col items-center justify-center text-center">
                                                    <span className="text-4xl font-bold tracking-tighter tabular-nums text-zinc-950 dark:text-white">
                                                        {freeSites ?? '—'}
                                                    </span>
                                                    <span className="text-[10px] font-bold tracking-widest text-zinc-400 uppercase">Frei</span>
                                                </div>
                                            </div>

                                            <div className="mt-8 grid w-full grid-cols-2 gap-3">
                                                <div className="rounded-xl bg-zinc-50 p-3 dark:bg-white/5">
                                                    <div className="text-[10px] font-bold text-zinc-400 uppercase tracking-wide">Gesamt</div>
                                                    <div className="text-lg font-bold text-zinc-950 dark:text-white">{parkingArea.capacity ?? '—'}</div>
                                                </div>
                                                <div className="rounded-xl bg-zinc-50 p-3 dark:bg-white/5">
                                                    <div className="text-[10px] font-bold text-zinc-400 uppercase tracking-wide">Belegt</div>
                                                    <div className="text-lg font-bold text-zinc-950 dark:text-white">{parkingArea.occupied ?? '—'}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="mt-4 space-y-2 border-t border-zinc-50 pt-4 dark:border-white/5">
                                            <div className="flex items-center justify-between text-xs font-bold">
                                                <span className="text-zinc-400 uppercase tracking-wider">Auslastung</span>
                                                <span className={occupancyPercentage > 90 ? 'text-amber-500' : 'text-accent-600'}>
                                                    {occupancyPercentage}%
                                                </span>
                                            </div>
                                            <div className="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-white/10">
                                                <motion.div
                                                    className={`h-full ${occupancyPercentage > 90 ? 'bg-amber-500' : 'bg-accent-600'}`}
                                                    initial={{ width: 0 }}
                                                    animate={{ width: `${occupancyPercentage}%` }}
                                                    transition={{ duration: 0.8 }}
                                                />
                                            </div>
                                            {parkingArea.updated_at && (
                                                <p className="mt-4 text-center text-[10px] font-medium text-zinc-400 uppercase tracking-widest">
                                                    Update: {format(parseISO(parkingArea.updated_at), 'HH:mm', { locale: de })} Uhr
                                                </p>
                                            )}
                                        </div>
                                    </CardContent>
                                </Card>
                            </motion.div>

                            <motion.div
                                initial={{ opacity: 0, y: 5 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.5 }}
                                className="rounded-xl border border-accent-100 bg-accent-50/30 p-4 dark:border-accent-500/10 dark:bg-accent-500/5"
                            >
                                <div className="flex gap-3">
                                    <Info className="size-4 shrink-0 text-accent-600" />
                                    <div className="text-xs leading-relaxed text-zinc-600 dark:text-zinc-400">
                                        Die Daten werden automatisch von den Parkhaussystemen übermittelt und alle 5 Minuten aktualisiert.
                                    </div>
                                </div>
                            </motion.div>
                        </div>

                        {/* Chart and Map Column */}
                        <div className="space-y-6 lg:col-span-2">
                            <motion.div
                                initial={{ opacity: 0, y: 10 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.4 }}
                            >
                                <Card className="border-zinc-200 bg-white py-0 shadow-xs dark:border-white/10 dark:bg-zinc-900">
                                    <CardHeader className="border-b border-zinc-100 py-4 dark:border-white/5">
                                        <div className="flex items-center justify-between">
                                            <div className="space-y-0.5">
                                                <CardTitle className="text-base font-bold">Historischer Verlauf</CardTitle>
                                                <CardDescription className="text-xs">Belegung der letzten 24 Stunden</CardDescription>
                                            </div>
                                            <TrendingUp className="size-4 text-accent-600" />
                                        </div>
                                    </CardHeader>
                                    <CardContent className="pt-6">
                                        <div className="h-[300px] w-full">
                                            {pastOccupancy.length > 0 ? (
                                                <Line
                                                    data={chartData}
                                                    options={chartOptions}
                                                />
                                            ) : (
                                                <div className="flex h-full flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-zinc-100 dark:border-white/5">
                                                    <TrendingUp className="size-6 text-zinc-200" />
                                                    <div className="text-xs font-medium text-zinc-400">
                                                        Keine historischen Daten verfügbar
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </CardContent>
                                </Card>
                            </motion.div>

                            <motion.div
                                initial={{ opacity: 0, y: 10 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.6 }}
                            >
                                <Card className="overflow-hidden border-zinc-200 bg-white py-0 shadow-xs dark:border-white/10 dark:bg-zinc-900">
                                    <CardHeader className="border-b border-zinc-100 py-4 dark:border-white/5">
                                        <CardTitle className="text-base font-bold">Standort</CardTitle>
                                    </CardHeader>
                                    <CardContent className="p-0">
                                        <div className="relative group">
                                            <div className="aspect-video w-full overflow-hidden md:aspect-[21/9]">
                                                {imageUrl ? (
                                                    <img
                                                        src={imageUrl}
                                                        alt={`Standort von ${parkingArea.name}`}
                                                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                    />
                                                ) : (
                                                    <div className="flex h-full w-full items-center justify-center bg-zinc-50 dark:bg-white/5">
                                                        <MapPin className="size-10 text-zinc-200" />
                                                    </div>
                                                )}
                                            </div>

                                            {/* Info Overlay Card - Re-designed to be more subtle */}
                                            <div className="absolute inset-x-3 bottom-3 md:inset-x-auto md:right-3 md:bottom-3 md:w-72">
                                                <div className="rounded-xl border border-white/20 bg-white/95 p-4 shadow-lg backdrop-blur-sm dark:border-white/10 dark:bg-zinc-900/95">
                                                    <div className="mb-3 flex items-center gap-3">
                                                        <div className="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-accent-600 text-white">
                                                            <MapPin className="size-4" />
                                                        </div>
                                                        <div className="min-w-0">
                                                            <div className="truncate text-sm font-bold text-zinc-950 dark:text-white">
                                                                {parkingArea.name}
                                                            </div>
                                                            <div className="text-[10px] font-medium text-zinc-500">47441 Moers, Deutschland</div>
                                                        </div>
                                                    </div>

                                                    <div className="flex gap-2">
                                                        {googleMapsUrl && (
                                                            <Button
                                                                asChild
                                                                size="sm"
                                                                className="flex-1 rounded-lg bg-accent-600 text-[11px] font-bold text-white shadow-sm hover:bg-accent-700"
                                                            >
                                                                <a href={googleMapsUrl} target="_blank" rel="noopener noreferrer">
                                                                    <Navigation className="mr-1 size-3" />
                                                                    Route
                                                                </a>
                                                            </Button>
                                                        )}
                                                        <Button
                                                            variant="outline"
                                                            size="icon"
                                                            className="h-8 w-8 shrink-0 rounded-lg"
                                                            asChild
                                                        >
                                                            <a
                                                                href={`https://www.google.com/maps/search/?api=1&query=${lat},${lng}`}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                            >
                                                                <ExternalLink className="size-3.5" />
                                                            </a>
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            </motion.div>
                        </div>
                    </div>
                </DefaultContainer>
            </div>
        </>
    );
};

ParkingShow.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ParkingShow;
