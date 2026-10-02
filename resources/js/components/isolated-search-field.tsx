import { Input, InputGroup } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Search } from 'lucide-react';
import React from 'react';

interface IsolatedSearchFieldProps extends React.InputHTMLAttributes<HTMLInputElement> {
    containerClassName?: string;
}

export function IsolatedSearchField({ containerClassName, className, ...props }: IsolatedSearchFieldProps) {
    return (
        <InputGroup className={cn('w-full', containerClassName)}>
            <Search data-slot="icon" />
            <Input
                {...props}
                type="text"
                className={cn('h-12 [&_input]:h-full', className)}
            />
        </InputGroup>
    );
}
