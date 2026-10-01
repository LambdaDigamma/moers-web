import { clsx } from 'clsx';
import React from 'react';

export const DefaultContainer = ({ className, children, ...props }: React.ComponentPropsWithoutRef<'div'>) => {
    return <div className={clsx('max-w-page mx-auto w-full px-4', className)}>{children}</div>;
};
