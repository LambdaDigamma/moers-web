import { DefaultContainer } from '@/components/default-container';
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
            <header className="border-border bg-background border-b">
                <DefaultContainer className="flex flex-col gap-8 py-12 md:py-16">
                    <div className="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                        <div className="flex max-w-3xl min-w-0 flex-col gap-3">
                            {badge && <div className="text-eyebrow text-accent-700 dark:text-accent-400">{badge}</div>}
                            <h1 className="font-display tracking-display text-foreground text-4xl leading-tight font-semibold sm:text-5xl lg:text-[56px]">
                                {title}
                            </h1>
                            {description && <p className="text-muted-foreground max-w-2xl text-base leading-7 sm:text-lg">{description}</p>}
                        </div>
                        {actions && <div className="flex shrink-0 flex-wrap items-center gap-3">{actions}</div>}
                    </div>
                    {children && <div className="relative">{children}</div>}
                </DefaultContainer>
            </header>
        </div>
    );
}
