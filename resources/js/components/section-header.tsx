import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';

type SectionHeaderProps = {
    eyebrow: string;
    title: string;
    action?: {
        label: string;
        href: string;
    };
    className?: string;
};

export function SectionHeader({ eyebrow, title, action, className }: SectionHeaderProps) {
    return (
        <div className={cn('flex flex-col justify-between gap-4 sm:flex-row sm:items-end', className)}>
            <div className="flex flex-col gap-2.5">
                <span className="text-eyebrow text-accent-700 dark:text-accent-400">{eyebrow}</span>
                <h2 className="font-display tracking-display text-foreground text-4xl leading-tight font-semibold md:text-[44px] md:leading-12">
                    {title}
                </h2>
            </div>
            {action && (
                <Link
                    href={action.href}
                    className="group text-foreground inline-flex items-center gap-1.5 text-[15px] leading-[18px] font-semibold"
                >
                    {action.label}
                    <ArrowRight className="size-4 transition-transform group-hover:translate-x-0.5" />
                </Link>
            )}
        </div>
    );
}
