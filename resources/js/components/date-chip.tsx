import { formatDate, formatWeekdayAbbreviation } from '@/lib/date-format';
import { cn } from '@/lib/utils';

type DateChipProps = {
    date: string | null;
    isHighlighted?: boolean;
    className?: string;
};

export function DateChip({ date, isHighlighted = false, className }: DateChipProps) {
    return (
        <div
            className={cn(
                'flex size-14 shrink-0 flex-col items-center justify-center rounded-lg border',
                isHighlighted ? 'border-primary bg-primary text-primary-foreground' : 'border-border bg-muted text-foreground',
                className,
            )}
        >
            {date ? (
                <>
                    <span
                        className={cn(
                            'text-[11px] leading-[14px] font-semibold tracking-[0.06em]',
                            isHighlighted ? 'text-accent-500 dark:text-accent-700' : 'text-accent-700 dark:text-accent-400',
                        )}
                    >
                        {formatWeekdayAbbreviation(date)}
                    </span>
                    <span className="font-display text-[21px] leading-6 font-bold tabular-nums">{formatDate(date, { day: '2-digit' })}</span>
                </>
            ) : (
                <span className="text-muted-foreground text-center text-[10px] leading-tight font-semibold uppercase">
                    Termin
                    <br />
                    offen
                </span>
            )}
        </div>
    );
}
