import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, CircleParking, MapPin } from 'lucide-react';
import { ReactNode } from 'react';
import ParkingArea = Modules.Parking.Data.ParkingArea;

interface Props {
    parkingAreas: ParkingArea[];
}

const container = {
    hidden: { opacity: 0 },
    show: {
        opacity: 1,
        transition: {
            staggerChildren: 0.05,
        },
    },
};

const item = {
    hidden: { opacity: 0, y: 10 },
    show: { opacity: 1, y: 0 },
};

const ParkingIndex = ({ parkingAreas }: Props) => {
    return (
        <>
            <Head title="Parken in Moers" />

            <div className="min-h-screen bg-[#FDFDFC] dark:bg-zinc-950">
                <PageHeader
                    badge="Live-Status"
                    title="Parken in Moers"
                    description="Finden Sie schnell und einfach freie Parkplätze in der Innenstadt. Wir zeigen Ihnen die aktuelle Belegung der wichtigsten Parkhäuser in Echtzeit."
                />

                <DefaultContainer className="py-12">
                    <motion.div
                        variants={container}
                        initial="hidden"
                        animate="show"
                        className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        {parkingAreas.map((area) => (
                            <motion.div key={area.id} variants={item}>
                                <Link
                                    href={route('parking-areas.show', [area.slug])}
                                    className="group block h-full"
                                >
                                    <Card className="h-full border-zinc-200 bg-white py-0 shadow-xs transition-all duration-200 hover:border-accent-200 hover:shadow-sm dark:border-white/10 dark:bg-zinc-900 dark:hover:border-accent-500/20">
                                        <CardHeader className="flex flex-row items-start justify-between space-y-0 border-b border-zinc-100 py-4 dark:border-white/5">
                                            <div className="space-y-0.5">
                                                <CardTitle className="text-lg font-bold tracking-tight text-zinc-950 dark:text-white">
                                                    {area.name}
                                                </CardTitle>
                                                <div className="flex items-center gap-1 text-xs font-medium text-zinc-500">
                                                    <MapPin className="size-3" />
                                                    Moers Innenstadt
                                                </div>
                                            </div>
                                            <Badge
                                                variant="outline"
                                                className={`rounded-full border-none px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide ${
                                                    area.state === 'open'
                                                        ? 'bg-accent-500/10 text-accent-700 dark:text-accent-400'
                                                        : 'bg-zinc-100 text-zinc-600 dark:bg-white/5 dark:text-zinc-400'
                                                }`}
                                            >
                                                {area.state === 'open' ? 'Offen' : 'Zu'}
                                            </Badge>
                                        </CardHeader>
                                        <CardContent className="pt-5 pb-4">
                                            <div className="flex items-end gap-1.5 mb-5">
                                                <div
                                                    className={`text-4xl font-bold tracking-tighter tabular-nums ${
                                                        area.capacity && area.occupied && area.capacity - area.occupied < 10
                                                            ? 'text-accent-500'
                                                            : 'text-zinc-950 dark:text-white'
                                                    }`}
                                                >
                                                    {area.capacity ? Math.max(0, area.capacity - area.occupied!) : '—'}
                                                </div>
                                                <div className="pb-1 text-xs font-semibold text-zinc-400 uppercase tracking-wider">
                                                    von {area.capacity ?? '—'} frei
                                                </div>
                                            </div>

                                            {/* Minimal Progress Bar */}
                                            <div className="h-1 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-white/10">
                                                <motion.div
                                                    className={`h-full ${
                                                        area.capacity && area.occupied && (area.occupied / area.capacity) > 0.9
                                                            ? 'bg-accent-500'
                                                            : 'bg-accent-600'
                                                    }`}
                                                    initial={{ width: 0 }}
                                                    animate={{
                                                        width: `${
                                                            area.capacity && area.occupied
                                                                ? Math.min(100, (area.occupied / area.capacity) * 100)
                                                                : 0
                                                        }%`,
                                                    }}
                                                    transition={{ duration: 0.8, ease: 'easeOut' }}
                                                />
                                            </div>

                                            <div className="mt-6 flex items-center justify-between pt-1">
                                                <span className="text-[11px] font-bold tracking-widest text-accent-600 uppercase dark:text-accent-400">
                                                    Details & Historie
                                                </span>
                                                <ArrowRight className="size-4 text-zinc-300 transition-transform group-hover:translate-x-1 group-hover:text-accent-600" />
                                            </div>
                                        </CardContent>
                                    </Card>
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </DefaultContainer>
            </div>
        </>
    );
};

ParkingIndex.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default ParkingIndex;
