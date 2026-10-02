import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { SeoHead } from '@/components/seo-head';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Link } from '@inertiajs/react';
import {
    CategoryScale,
    Chart as ChartJS,
    Filler,
    LinearScale,
    LineElement,
    PointElement,
    Title,
    Tooltip,
    type ChartData,
    type ChartOptions,
} from 'chart.js';
import { format, parseISO } from 'date-fns';
import { de } from 'date-fns/locale';
import { motion } from 'framer-motion';
import { ArrowLeft, ExternalLink, Info, MapPin, Navigation, TrendingUp } from 'lucide-react';
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

    const chartData = useMemo<ChartData<'line'>>(() => {
        const labels = pastOccupancy.map((d) => `${String(d.hour).padStart(2, '0')}:00`);
        const data = pastOccupancy.map((d) => Number(d.occupancy_rate) * 100);

        return {
            labels,
            datasets: [
                {
                    label: 'Belegung',
                    data,
                    fill: true,
                    borderColor: 'rgb(116, 119, 125)',
                    borderWidth: 2,
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return undefined;
                        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0, 'rgba(116, 119, 125, 0.12)');
                        gradient.addColorStop(1, 'rgba(116, 119, 125, 0)');
                        return gradient;
                    },
                    tension: 0.3,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: 'rgb(116, 119, 125)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                },
            ],
        };
    }, [pastOccupancy]);

    const chartOptions: ChartOptions<'line'> = {
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
                    label: (context) => ` ${(context.parsed.y ?? 0).toFixed(1)}% belegt`,
                },
            },
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: (value) => `${value}%`,
                    stepSize: 25,
                    font: { size: 10 },
                    color: '#71717a',
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.04)',
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
            <SeoHead
                title={`${parkingArea.name} - Parken in Moers`}
                description={`Aktuelle Belegung, Öffnungsstatus und Standortinformationen für ${parkingArea.name} in Moers.`}
            />

            <div className="bg-background min-h-screen">
                <PageHeader
                    badge="Parkhäuser live"
                    title={parkingArea.name}
                    description={`Moers Innenstadt · ${parkingArea.state === 'open' ? 'Geöffnet' : 'Geschlossen'}`}
                    actions={
                        <>
                            <Button
                                asChild
                                variant="outline"
                            >
                                <Link href={route('parking-areas.index')}>
                                    <ArrowLeft data-icon="inline-start" />
                                    Alle Parkhäuser
                                </Link>
                            </Button>
                            {googleMapsUrl && (
                                <Button asChild>
                                    <a
                                        href={googleMapsUrl}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <Navigation data-icon="inline-start" />
                                        Route planen
                                    </a>
                                </Button>
                            )}
                        </>
                    }
                />
                <DefaultContainer className="py-10">
                    <div className="grid gap-6 lg:grid-cols-3">
                        {/* Main Status Column */}
                        <div className="space-y-6 lg:col-span-1">
                            <motion.div
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ delay: 0.3 }}
                            >
                                <Card className="border-border bg-card overflow-hidden py-0 shadow-none">
                                    <CardHeader className="border-border border-b py-4">
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-base font-semibold">Verfügbarkeit</CardTitle>
                                            <Badge
                                                variant="outline"
                                                className="h-5 bg-zinc-50 px-2 text-[10px] font-semibold tracking-wider uppercase dark:bg-zinc-800"
                                            >
                                                Live
                                            </Badge>
                                        </div>
                                    </CardHeader>
                                    <CardContent className="p-6">
                                        <div className="flex flex-col items-center justify-center py-4">
                                            <div className="relative h-40 w-40">
                                                <svg
                                                    className="h-full w-full"
                                                    viewBox="0 0 100 100"
                                                >
                                                    <circle
                                                        className="text-secondary stroke-current"
                                                        strokeWidth="6"
                                                        fill="transparent"
                                                        r="44"
                                                        cx="50"
                                                        cy="50"
                                                    />
                                                    <motion.circle
                                                        className="text-foreground stroke-current"
                                                        strokeWidth="6"
                                                        strokeLinecap="round"
                                                        fill="transparent"
                                                        r="44"
                                                        cx="50"
                                                        cy="50"
                                                        initial={{ strokeDasharray: '0 277' }}
                                                        animate={{ strokeDasharray: `${(occupancyPercentage * 277) / 100} 277` }}
                                                        transition={{ duration: 1, ease: 'easeOut' }}
                                                        style={{ transform: 'rotate(-90deg)', transformOrigin: '50% 50%' }}
                                                    />
                                                </svg>
                                                <div className="absolute inset-0 flex flex-col items-center justify-center text-center">
                                                    <span className="text-foreground text-4xl font-semibold tracking-tighter tabular-nums">
                                                        {freeSites ?? '—'}
                                                    </span>
                                                    <span className="text-[10px] font-semibold tracking-widest text-zinc-400 uppercase">Frei</span>
                                                </div>
                                            </div>

                                            <div className="mt-8 grid w-full grid-cols-2 gap-3">
                                                <div className="bg-muted rounded-xl p-3">
                                                    <div className="text-[10px] font-semibold tracking-wide text-zinc-400 uppercase">Gesamt</div>
                                                    <div className="text-foreground text-lg font-semibold">{parkingArea.capacity ?? '—'}</div>
                                                </div>
                                                <div className="bg-muted rounded-xl p-3">
                                                    <div className="text-[10px] font-semibold tracking-wide text-zinc-400 uppercase">Belegt</div>
                                                    <div className="text-foreground text-lg font-semibold">{parkingArea.occupied ?? '—'}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="mt-4 space-y-2 border-t border-zinc-50 pt-4 dark:border-white/5">
                                            <div className="flex items-center justify-between text-xs font-semibold">
                                                <span className="tracking-wider text-zinc-400 uppercase">Auslastung</span>
                                                <span className={occupancyPercentage > 90 ? 'text-warning' : 'text-foreground'}>
                                                    {occupancyPercentage}%
                                                </span>
                                            </div>
                                            <div className="bg-secondary h-1.5 w-full overflow-hidden rounded-full">
                                                <motion.div
                                                    className={`h-full ${occupancyPercentage > 90 ? 'bg-warning' : 'bg-foreground'}`}
                                                    initial={{ width: 0 }}
                                                    animate={{ width: `${occupancyPercentage}%` }}
                                                    transition={{ duration: 0.8 }}
                                                />
                                            </div>
                                            {parkingArea.updated_at && (
                                                <p className="mt-4 text-center text-[10px] font-medium tracking-widest text-zinc-400 uppercase">
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
                                className="border-border bg-muted rounded-xl border p-4"
                            >
                                <div className="flex gap-3">
                                    <Info className="text-accent-600 size-4 shrink-0" />
                                    <div className="text-muted-foreground text-xs leading-relaxed">
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
                                <Card className="border-border bg-card py-0 shadow-none">
                                    <CardHeader className="border-border border-b py-4">
                                        <div className="flex items-center justify-between">
                                            <div className="space-y-0.5">
                                                <CardTitle className="text-base font-semibold">Historischer Verlauf</CardTitle>
                                                <CardDescription className="text-xs">Belegung der letzten 24 Stunden</CardDescription>
                                            </div>
                                            <TrendingUp className="text-accent-600 size-4" />
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
                                                <div className="border-border flex h-full flex-col items-center justify-center gap-2 rounded-xl border border-dashed">
                                                    <TrendingUp className="size-6 text-zinc-200" />
                                                    <div className="text-xs font-medium text-zinc-400">Keine historischen Daten verfügbar</div>
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
                                <Card className="border-border bg-card overflow-hidden py-0 shadow-none">
                                    <CardHeader className="border-border border-b py-4">
                                        <CardTitle className="text-base font-semibold">Standort</CardTitle>
                                    </CardHeader>
                                    <CardContent className="p-0">
                                        <div className="group relative">
                                            <div className="aspect-video w-full overflow-hidden md:aspect-[21/9]">
                                                {imageUrl ? (
                                                    <img
                                                        src={imageUrl}
                                                        alt={`Standort von ${parkingArea.name}`}
                                                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                    />
                                                ) : (
                                                    <div className="bg-muted flex h-full w-full items-center justify-center">
                                                        <MapPin className="size-10 text-zinc-200" />
                                                    </div>
                                                )}
                                            </div>

                                            {/* Info Overlay Card - Re-designed to be more subtle */}
                                            <div className="absolute inset-x-3 bottom-3 md:inset-x-auto md:right-3 md:bottom-3 md:w-72">
                                                <div className="border-border bg-card rounded-xl border p-4 shadow-sm">
                                                    <div className="mb-3 flex items-center gap-3">
                                                        <div className="bg-muted text-foreground flex size-8 shrink-0 items-center justify-center rounded-lg">
                                                            <MapPin className="size-4" />
                                                        </div>
                                                        <div className="min-w-0">
                                                            <div className="text-foreground truncate text-sm font-semibold">{parkingArea.name}</div>
                                                            <div className="text-[10px] font-medium text-zinc-500">47441 Moers, Deutschland</div>
                                                        </div>
                                                    </div>

                                                    <div className="flex gap-2">
                                                        {googleMapsUrl && (
                                                            <Button
                                                                asChild
                                                                size="sm"
                                                                className="flex-1"
                                                            >
                                                                <a
                                                                    href={googleMapsUrl}
                                                                    target="_blank"
                                                                    rel="noopener noreferrer"
                                                                >
                                                                    <Navigation className="mr-1 size-3" />
                                                                    Route
                                                                </a>
                                                            </Button>
                                                        )}
                                                        <Button
                                                            variant="outline"
                                                            size="icon"
                                                            aria-label="Standort in Google Maps öffnen"
                                                            className="size-8 shrink-0"
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
