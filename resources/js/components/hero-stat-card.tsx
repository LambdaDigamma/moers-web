import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { ArrowUpRight, type LucideIcon } from 'lucide-react';

type HeroStatCardProps = {
    icon: LucideIcon;
    label: string;
    value: string;
    caption: string;
    href: string;
    isLoading?: boolean;
    className?: string;
};

export function HeroStatCard({ icon: Icon, label, value, caption, href, isLoading = false, className }: HeroStatCardProps) {
    return (
        <Link
            href={href}
            className={cn(
                'group border-hero-divider bg-hero-surface focus-visible:outline-ring flex flex-col gap-[18px] rounded-2xl border p-6 transition-colors hover:bg-white/8 focus-visible:outline-2 focus-visible:outline-offset-2',
                className,
            )}
        >
            <div className="flex items-center justify-between gap-3">
                <div className="text-hero-muted flex min-w-0 items-center gap-2.5 text-sm leading-[18px] font-medium">
                    <Icon
                        className="size-[18px] shrink-0"
                        strokeWidth={1.75}
                    />
                    <span className="truncate">{label}</span>
                </div>
                <ArrowUpRight className="text-hero-subtle size-4 shrink-0 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
            </div>
            {isLoading ? (
                <div className="flex flex-col gap-1">
                    <div className="h-12 w-40 animate-pulse rounded-md bg-white/10" />
                    <div className="h-[18px] w-52 animate-pulse rounded bg-white/10" />
                </div>
            ) : (
                <div className="flex flex-col gap-1">
                    <span className="font-display tracking-display text-hero-foreground text-[44px] leading-12 font-semibold tabular-nums">
                        {value}
                    </span>
                    <span className="text-hero-subtle text-[15px] leading-[18px]">{caption}</span>
                </div>
            )}
        </Link>
    );
}
