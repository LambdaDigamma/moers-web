import { DefaultContainer } from '@/components/default-container';
import { Heading } from '@/components/ui/heading';
import { cn } from '@/lib/utils';
import { ReactNode } from 'react';

interface PageHeaderProps {
    title: ReactNode;
    description?: ReactNode;
    badge?: ReactNode;
    actions?: ReactNode;
    children?: ReactNode;
    className?: string;
}

export function PageHeader({ title, description, badge, actions, children, className }: PageHeaderProps) {
    return (
        <div className={cn('relative', className)}>
            <header className="relative overflow-hidden border-b border-zinc-200 bg-white py-16 lg:py-20 dark:border-white/5 dark:bg-zinc-900/50">
                <div className="absolute inset-0 bg-linear-to-br from-emerald-500/5 via-transparent to-sky-500/5" />
                <DefaultContainer className="relative">
                    <div className="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div className="max-w-2xl space-y-6">
                            {badge && (
                                <div className="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50/50 px-3 py-1 text-xs font-medium tracking-wide text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <div className="size-1.5 animate-pulse rounded-full bg-emerald-500" />
                                    {badge}
                                </div>
                            )}
                            <div className="space-y-4">
                                <Heading className="text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl lg:text-6xl dark:text-white">
                                    {title}
                                </Heading>
                                {description && <p className="text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">{description}</p>}
                            </div>
                        </div>
                        {actions && <div className="flex shrink-0 gap-3">{actions}</div>}
                    </div>
                </DefaultContainer>
            </header>

            {children && (
                <div className="relative z-10 -mt-10 lg:-mt-12">
                    <DefaultContainer>{children}</DefaultContainer>
                </div>
            )}
        </div>
    );
}
