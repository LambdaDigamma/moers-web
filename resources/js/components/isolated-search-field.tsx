import { Search } from 'lucide-react';
import React from 'react';

interface IsolatedSearchFieldProps extends React.InputHTMLAttributes<HTMLInputElement> {
    containerClassName?: string;
}

export function IsolatedSearchField({ containerClassName, className, ...props }: IsolatedSearchFieldProps) {
    return (
        <div className={`relative group w-full ${containerClassName}`}>
            <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                <Search className="size-5 text-zinc-400 transition-colors group-focus-within:text-emerald-500 dark:text-zinc-500" />
            </div>
            <input
                {...props}
                type="text"
                className={`block w-full rounded-2xl border border-zinc-200 bg-white py-4 pl-14 pr-6 text-base text-zinc-950 shadow-2xl shadow-zinc-200/60 outline-none transition-all placeholder:text-zinc-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 dark:border-white/10 dark:bg-zinc-900 dark:text-white dark:shadow-none dark:placeholder:text-zinc-500 dark:focus:border-emerald-500 ${className}`}
            />
        </div>
    );
}
