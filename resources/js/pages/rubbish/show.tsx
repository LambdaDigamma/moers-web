import { DefaultContainer } from '@/components/default-container';
import { RubbishStreetSearch } from '@/components/rubbish-street-search';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { usePrimaryRubbishStreet } from '@/hooks/use-primary-rubbish-street';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Head } from '@inertiajs/react';
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
        badgeClass: 'bg-emerald-600 text-white',
        dotClass: 'bg-emerald-600',
    },
    paper: {
        label: 'Papier',
        icon: FileText,
        badgeClass: 'bg-sky-600 text-white',
        dotClass: 'bg-sky-600',
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
        badgeClass: 'bg-lime-600 text-white',
        dotClass: 'bg-lime-600',
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

            <DefaultContainer className="space-y-6 py-6">
                <RubbishStreetSearch
                    activeStreet={street}
                    initialQuery={street.name}
                />

                <div className="space-y-6">
                    <Card className="border-emerald-200 bg-linear-to-r from-emerald-50 via-white to-lime-50 py-0 dark:border-emerald-500/20 dark:from-emerald-500/10 dark:via-transparent dark:to-lime-500/5">
                        <CardHeader className="gap-4 py-5">
                            <div className="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <CardTitle className="text-3xl tracking-tight text-zinc-950">{street.name}</CardTitle>
                                    <CardDescription className="mt-1 text-base text-zinc-700">
                                        {street.street_addition || 'Abfallkalender und Terminübersicht'}
                                    </CardDescription>
                                </div>

                                <div className="flex flex-wrap items-center gap-3 sm:justify-end">
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
                                                isPrimaryStreet && 'bg-emerald-600 text-white hover:bg-emerald-700 dark:bg-emerald-500',
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
                                                        Outlook Kalender
                                                    </a>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
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
                        <div className="grid gap-6 xl:grid-cols-[minmax(0,1.1fr)_minmax(22rem,0.9fr)]">
                            <Card className="py-0">
                                <CardHeader className="border-b border-zinc-200/80 py-4 dark:border-white/10">
                                    <div className="flex items-center justify-between gap-4">
                                        <div>
                                            <CardTitle className="text-lg">Termine</CardTitle>
                                        </div>
                                        <Badge
                                            variant="outline"
                                            className="rounded-full px-3 py-1"
                                        >
                                            {pickupGroups.length} Einträge
                                        </Badge>
                                    </div>
                                </CardHeader>
                                <CardContent className="p-0">
                                    <div className="max-h-136 overflow-y-auto p-3">
                                        <div className="space-y-2">
                                            {pickupGroups.map((group) => (
                                                <div
                                                    key={group.date}
                                                    className="rounded-xl border border-zinc-200 bg-white px-3 py-3 shadow-xs dark:border-white/10 dark:bg-white/[0.02]"
                                                >
                                                    <div className="flex flex-wrap items-start justify-between gap-3">
                                                        <div className="space-y-1">
                                                            <div className="text-sm font-semibold text-zinc-950 dark:text-white">
                                                                {formatListDate(group.date)}
                                                            </div>
                                                            <div className="text-xs text-zinc-500 dark:text-zinc-400">
                                                                {formatLongDate(group.date)}
                                                            </div>
                                                        </div>
                                                        <div className="flex flex-wrap justify-end gap-2">
                                                            {group.items.map((item, index) => {
                                                                const meta = pickupMeta[item.type];

                                                                return (
                                                                    <Badge
                                                                        key={`${group.date}-${item.type}-${index}`}
                                                                        className={cn('rounded-full px-3 py-1 text-xs font-medium', meta.badgeClass)}
                                                                    >
                                                                        {meta.label}
                                                                    </Badge>
                                                                );
                                                            })}
                                                        </div>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>

                            <Card className="py-0">
                                <CardHeader className="border-b border-zinc-200/80 py-4 dark:border-white/10">
                                    <div className="flex items-center justify-between gap-3">
                                        <div>
                                            <CardTitle className="text-lg">Kalender</CardTitle>
                                        </div>
                                        {monthKeys.length > 1 ? (
                                            <div className="flex items-center gap-1">
                                                <Button
                                                    type="button"
                                                    variant="ghost"
                                                    size="icon"
                                                    className="size-8"
                                                    disabled={monthIndex <= 0}
                                                    onClick={() => setSelectedMonth(monthKeys[monthIndex - 1])}
                                                >
                                                    <ChevronLeft className="size-4" />
                                                </Button>
                                                <Button
                                                    type="button"
                                                    variant="ghost"
                                                    size="icon"
                                                    className="size-8"
                                                    disabled={monthIndex === -1 || monthIndex >= monthKeys.length - 1}
                                                    onClick={() => setSelectedMonth(monthKeys[monthIndex + 1])}
                                                >
                                                    <ChevronRight className="size-4" />
                                                </Button>
                                            </div>
                                        ) : null}
                                    </div>
                                </CardHeader>
                                <CardContent className="space-y-4 p-4">
                                    {selectedMonth ? (
                                        <>
                                            <div className="flex items-center justify-between gap-3">
                                                <div className="text-base font-semibold text-zinc-950 capitalize dark:text-white">
                                                    {formatMonthLabel(selectedMonth)}
                                                </div>
                                            </div>

                                            <div className="grid grid-cols-7 gap-1 text-center text-xs font-medium tracking-[0.16em] text-zinc-400 uppercase">
                                                {weekdayLabels.map((label) => (
                                                    <div
                                                        key={label}
                                                        className="py-1"
                                                    >
                                                        {label}
                                                    </div>
                                                ))}
                                            </div>

                                            <div className="grid grid-cols-7 gap-1.5">
                                                {calendarDays.map((day) => {
                                                    const key = dateKey(day);
                                                    const dayItems = pickupMap[key] ?? [];
                                                    const isCurrentMonth = key.startsWith(selectedMonth);

                                                    const cell = (
                                                        <div
                                                            className={cn(
                                                                'flex aspect-square min-h-14 flex-col justify-between rounded-xl border px-2 py-2 text-left transition',
                                                                isCurrentMonth
                                                                    ? 'border-zinc-200 bg-white hover:border-emerald-300 dark:border-white/10 dark:bg-white/[0.02] dark:hover:border-emerald-500/30'
                                                                    : 'border-transparent bg-zinc-50 text-zinc-300 dark:bg-transparent dark:text-zinc-700',
                                                                dayItems.length > 0 && isCurrentMonth
                                                                    ? 'ring-1 ring-emerald-100 dark:ring-emerald-500/10'
                                                                    : '',
                                                            )}
                                                        >
                                                            <span className="text-sm font-medium">{day.getDate()}</span>
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
                    )}
                </div>
            </DefaultContainer>
        </>
    );
}

RubbishShow.layout = (page: ReactNode) => <AppLayout children={page} />;

export default RubbishShow;
