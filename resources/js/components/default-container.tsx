import { clsx } from 'clsx';
import React from 'react';

export const DefaultContainer = ({ className, children, ...props }: React.ComponentPropsWithoutRef<'div'>) => {
    return <div className={clsx('mx-auto w-full max-w-7xl px-4', className)}>{children}</div>;
};
