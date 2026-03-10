import { DefaultContainer } from '@/components/default-container';
import { PageHeader } from '@/components/page-header';
import { RubbishStreetSearch } from '@/components/rubbish-street-search';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Head, Link } from '@inertiajs/react';
import { CalendarPlus, ChevronLeft, ChevronRight, Download, FileText, Leaf, Recycle, Star, Trash2 } from 'lucide-react';
import { ReactNode, useEffect, useState } from 'react';

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
        pdf_download_url: string;
        pdf_view_url: string;
        full_pdf_url: string;
        ics_download_url: string;
        ics_subscribe_url: string;
        apple_calendar_url: string;
        google_calendar_url: string;
        outlook_calendar_url: string;
    };
};

const weekdayLabels = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];

const pickupMeta: Record<
    PickupItem['type'],
    {
        badgeClass: string;
        dotClass: string;
        icon: typeof Trash2;
        label: string;
    }
> = {
    residual: {
        label: 'Restmüll',
        icon: Trash2,
        badgeClass: 'bg-zinc-950 text-white dark:bg-zinc-100 dark:text-zinc-950',
        dotClass: 'bg-zinc-950 dark:bg-zinc-100',
    },
    organic: {
        label: 'Biotonne',
        icon: Leaf,
        badgeClass: 'bg-accent-600 text-white',
        dotClass: 'bg-accent-600',
    },
    paper: {
        label: 'Papier',
        icon: FileText,
        badgeClass: 'bg-accent-600 text-white',
        dotClass: 'bg-accent-600',
    },
    plastic: {
        label: 'Gelber Sack',
        icon: Recycle,
        badgeClass: 'bg-amber-300 text-zinc-950',
        dotClass: 'bg-amber-400',
    },
    cuttings: {
        label: 'Grünschnitt',
        icon: Leaf,
        badgeClass: 'bg-accent-600 text-white',
        dotClass: 'bg-accent-600',
    },
};

function formatLongDate(date: string): string {
    return new Intl.DateTimeFormat('de-DE', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(date));
}

function formatListDate(date: string): string {
    return new Intl.DateTimeFormat('de-DE', {
        weekday: 'short',
        day: '2-digit',
        month: '2-digit',
    }).format(new Date(date));
}

function formatMonthLabel(monthKey: string): string {
    return new Intl.DateTimeFormat('de-DE', {
        month: 'long',
        year: 'numeric',
    }).format(new Date(`${monthKey}-01T12:00:00`));
}

function buildCalendarDays(monthKey: string): Date[] {
    const [year, month] = monthKey.split('-').map(Number);
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const firstWeekday = (firstDay.getDay() + 6) % 7;
    const lastWeekday = (lastDay.getDay() + 6) % 7;
    const start = new Date(year, month - 1, 1 - firstWeekday);
    const end = new Date(year, month - 1, lastDay.getDate() + (6 - lastWeekday));
    const days: Date[] = [];

    for (const cursor = new Date(start); cursor <= end; cursor.setDate(cursor.getDate() + 1)) {
        days.push(new Date(cursor));
    }

    return days;
}

function dateKey(date: Date): string {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
}

const todayKey = dateKey(new Date());

function RubbishShow({ street, pickupGroups, downloads }: RubbishShowProps) {
    const { primaryStreet, isLoaded, setPrimaryStreet, clearPrimaryStreet } = usePrimaryRubbishStreet();
    const isPrimaryStreet = primaryStreet?.id === street.id;
    const monthKeys = Array.from(new Set(pickupGroups.map((group) => group.date.slice(0, 7))));
    const [selectedMonth, setSelectedMonth] = useState(monthKeys[0] ?? '');
    const pickupMap = Object.fromEntries(pickupGroups.map((group) => [group.date, group.items]));
    const monthIndex = monthKeys.indexOf(selectedMonth);
    const calendarDays = selectedMonth ? buildCalendarDays(selectedMonth) : [];

    useEffect(() => {
        if (!monthKeys.includes(selectedMonth)) {
            setSelectedMonth(monthKeys[0] ?? '');
        }
    }, [monthKeys, selectedMonth]);

    return (
        <>
            <Head title={`Abfallkalender ${street.name}`} />

            <div className="min-h-screen bg-zinc-50 dark:bg-zinc-950">
                <PageHeader
                    badge={
                        <Link
                            href={route('rubbish.index')}
                            className="flex items-center gap-1.5 transition-colors hover:text-accent-900 dark:hover:text-accent-300"
                        >
                            <ChevronLeft className="size-3.5" />
                            Abfallkalender Übersicht
                        </Link>
                    }
                    title={street.name}
                    description={street.street_addition || 'Abfallkalender und Terminübersicht'}
                    actions={
                        <div className="flex flex-wrap items-center gap-3">
                            {isLoaded ? (
                                <Button
                                    type="button"
                                    variant={isPrimaryStreet ? 'secondary' : 'outline'}
                                    size="sm"
                                    onClick={
                                        isPrimaryStreet
                                            ? clearPrimaryStreet
                                            : () =>
                                                  setPrimaryStreet({
                                                      id: street.id,
                                                      name: street.name,
                                                      street_addition: street.street_addition,
                                                  })
                                    }
                                    className={cn(
                                        'h-9 rounded-full px-4 font-medium transition-all',
                                        isPrimaryStreet && 'bg-accent-600 text-white hover:bg-accent-700 dark:bg-accent-500',
                                    )}
                                >
                                    <Star className={cn('mr-2 size-4', isPrimaryStreet && 'fill-current')} />
                                    {isPrimaryStreet ? 'Gespeichert' : 'Meine Straße'}
                                </Button>
                            ) : null}

                            <div className="hidden h-8 w-px bg-zinc-200 sm:block dark:bg-white/10" />

                            <div className="flex items-center gap-2">
                                <Button
                                    asChild
                                    variant="outline"
                                    size="sm"
                                    className="h-9 rounded-full px-4"
                                >
                                    <a
                                        href={downloads.pdf_download_url}
                                        target="_blank"
                                        rel="noreferrer"
                                        download
                                    >
                                        <Download className="mr-2 size-4" />
                                        PDF
                                    </a>
                                </Button>

                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            className="h-9 rounded-full px-4"
                                        >
                                            <CalendarPlus className="mr-2 size-4" />
                                            Abonnieren
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent
                                        align="end"
                                        className="w-56"
                                    >
                                        <DropdownMenuLabel className="text-[10px] font-bold tracking-wider text-zinc-500 uppercase">
                                            Downloads
                                        </DropdownMenuLabel>
                                        <DropdownMenuItem asChild>
                                            <a
                                                href={downloads.ics_download_url}
                                                download
                                                className="cursor-pointer"
                                            >
                                                ICS Kalenderdatei
                                            </a>
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuLabel className="text-[10px] font-bold tracking-wider text-zinc-500 uppercase">
                                            Kalender-Abo
                                        </DropdownMenuLabel>
                                        <DropdownMenuItem asChild>
                                            <a
                                                href={downloads.apple_calendar_url}
                                                className="cursor-pointer"
                                            >
                                                Apple Kalender
                                            </a>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <a
                                                href={downloads.google_calendar_url}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="cursor-pointer"
                                            >
                                                Google Kalender
                                            </a>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem asChild>
                                            <a
                                                href={downloads.outlook_calendar_url}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="cursor-pointer"
                                            >
                                                Outlook / Web
                                            </a>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>
                    }
                >
                    <div className="max-w-2xl">
                        <RubbishStreetSearch
                            activeStreet={street}
                            initialQuery={street.name}
                        />
                    </div>
                </PageHeader>

                <DefaultContainer className="py-12">
                    {pickupGroups.length === 0 ? (
                        <div className="flex flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 py-24 text-center dark:border-white/10">
                            <Trash2 className="size-12 text-zinc-300 dark:text-zinc-700" />
                            <h3 className="mt-4 text-lg font-semibold text-zinc-950 dark:text-white">Keine Termine verfügbar</h3>
                            <p className="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                Für diese Straße wurden aktuell keine Abholtermine gefunden.
                            </p>
                        </div>
                    ) : (
                        <div className="space-y-8">
                            {/* Month Navigation - Spans full width */}
                            <div className="flex items-center justify-between gap-4 rounded-[2.5rem] border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-zinc-900">
                                <Button
                                    variant="ghost"
                                    size="lg"
                                    className="h-14 w-14 rounded-full"
                                    disabled={monthIndex <= 0}
                                    onClick={() => setSelectedMonth(monthKeys[monthIndex - 1])}
                                >
                                    <ChevronLeft className="size-6" />
                                </Button>

                                <div className="text-2xl font-black tracking-tight text-zinc-950 dark:text-white">
                                    {selectedMonth ? formatMonthLabel(selectedMonth) : ''}
                                </div>

                                <Button
                                    variant="ghost"
                                    size="lg"
                                    className="h-14 w-14 rounded-full"
                                    disabled={monthIndex >= monthKeys.length - 1}
                                    onClick={() => setSelectedMonth(monthKeys[monthIndex + 1])}
                                >
                                    <ChevronRight className="size-6" />
                                </Button>
                            </div>

                            <div className="grid gap-8 lg:grid-cols-12">
                                {/* Desktop: List */}
                                <div className="space-y-6 lg:col-span-5">
                                    <h2 className="text-xl font-bold text-zinc-950 dark:text-white">Termine in diesem Monat</h2>

                                    <div className="space-y-3">
                                        {pickupGroups
                                            .filter((group) => group.date.startsWith(selectedMonth))
                                            .map((group) => (
                                                <div
                                                    key={group.date}
                                                    className={cn(
                                                        'flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-4 transition-all dark:border-white/5 dark:bg-zinc-900',
                                                        group.date === todayKey && 'border-accent-500 bg-accent-50/30 ring-1 ring-accent-500',
                                                    )}
                                                >
                                                    <div className="flex flex-col items-center border-r border-zinc-100 pr-4 dark:border-white/5">
                                                        <div className="text-xs font-bold text-zinc-400 uppercase">
                                                            {formatListDate(group.date).split(' ')[0]}
                                                        </div>
                                                        <div className="text-xl font-black text-zinc-950 tabular-nums dark:text-white">
                                                            {formatListDate(group.date).split(' ')[1].split('.')[0]}
                                                        </div>
                                                    </div>
                                                    <div className="flex flex-wrap gap-2">
                                                        {group.items.map((item, index) => (
                                                            <Badge
                                                                key={`${group.date}-${item.type}-${index}`}
                                                                className={cn(
                                                                    'rounded-full px-3 py-1 text-xs font-semibold',
                                                                    pickupMeta[item.type].badgeClass,
                                                                )}
                                                            >
                                                                <Trash2 className="mr-1.5 size-3" />
                                                                {pickupMeta[item.type].label}
                                                            </Badge>
                                                        ))}
                                                    </div>
                                                </div>
                                            ))}
                                    </div>
                                </div>

                                {/* Desktop: Calendar View */}
                                <Card className="overflow-hidden rounded-3xl lg:col-span-7">
                                    <CardHeader className="border-b border-zinc-100 px-6 py-4 dark:border-white/5">
                                        <CardTitle className="text-base font-bold">Kalenderansicht</CardTitle>
                                    </CardHeader>
                                    <CardContent className="p-6">
                                        {selectedMonth ? (
                                            <>
                                                <div className="mb-4 grid grid-cols-7 gap-1">
                                                    {weekdayLabels.map((label) => (
                                                        <div
                                                            key={label}
                                                            className="py-2 text-center text-[10px] font-bold tracking-wider text-zinc-400 uppercase"
                                                        >
                                                            {label}
                                                        </div>
                                                    ))}
                                                </div>
                                                <div className="grid grid-cols-7 gap-px overflow-hidden rounded-xl border border-zinc-100 bg-zinc-100 dark:border-white/5 dark:bg-white/5">
                                                    {calendarDays.map((day) => {
                                                        const key = dateKey(day);
                                                        const isCurrentMonth = selectedMonth === key.slice(0, 7);
                                                        const isToday = key === todayKey;
                                                        const dayItems = pickupMap[key] || [];

                                                        const cell = (
                                                            <div
                                                                className={cn(
                                                                    'min-h-[80px] bg-white p-2 transition-colors dark:bg-zinc-900',
                                                                    !isCurrentMonth
                                                                        ? 'bg-zinc-50/50 text-zinc-300 dark:bg-zinc-950/50 dark:text-zinc-700'
                                                                        : '',
                                                                    isToday &&
                                                                        'border-accent-500 bg-accent-50/30 ring-2 ring-accent-500 dark:bg-accent-500/10',
                                                                )}
                                                            >
                                                                <span
                                                                    className={cn(
                                                                        'text-sm font-medium',
                                                                        isToday && 'font-bold text-accent-700 dark:text-accent-400',
                                                                    )}
                                                                >
                                                                    {day.getDate()}
                                                                </span>
                                                                <div className="flex flex-wrap gap-1">
                                                                    {dayItems.slice(0, 3).map((item, index) => (
                                                                        <span
                                                                            key={`${key}-${item.type}-${index}`}
                                                                            className={cn('size-1.5 rounded-full', pickupMeta[item.type].dotClass)}
                                                                        />
                                                                    ))}
                                                                </div>
                                                            </div>
                                                        );

                                                        if (!isCurrentMonth || dayItems.length === 0) {
                                                            return <div key={key}>{cell}</div>;
                                                        }

                                                        return (
                                                            <Tooltip key={key}>
                                                                <TooltipTrigger asChild>
                                                                    <div>{cell}</div>
                                                                </TooltipTrigger>
                                                                <TooltipContent
                                                                    className="max-w-56 rounded-xl px-4 py-3 text-left"
                                                                    side="top"
                                                                >
                                                                    <div className="space-y-2">
                                                                        <div className="text-sm font-semibold">{formatLongDate(key)}</div>
                                                                        <div className="flex flex-wrap gap-1.5">
                                                                            {dayItems.map((item, index) => (
                                                                                <Badge
                                                                                    key={`${key}-${item.type}-${index}`}
                                                                                    className={cn(
                                                                                        'rounded-full px-2.5 py-1 text-[11px] font-medium',
                                                                                        pickupMeta[item.type].badgeClass,
                                                                                    )}
                                                                                >
                                                                                    {pickupMeta[item.type].label}
                                                                                </Badge>
                                                                            ))}
                                                                        </div>
                                                                    </div>
                                                                </TooltipContent>
                                                            </Tooltip>
                                                        );
                                                    })}
                                                </div>
                                            </>
                                        ) : null}
                                    </CardContent>
                                </Card>
                            </div>
                        </div>
                    )}
                </DefaultContainer>
            </div>
        </>
    );
}

RubbishShow.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishShow;
