import { cn } from '@/lib/utils';
import React from 'react';

export const DefaultContainer = ({ className, children, ...props }: React.ComponentPropsWithoutRef<'div'>) => {
    return (
        <div
            className={cn('max-w-page mx-auto w-full px-4 sm:px-6 lg:px-8', className)}
            {...props}
        >
            {children}
        </div>
    );
};
