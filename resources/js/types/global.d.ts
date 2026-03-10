import type { route as routeFn } from 'ziggy-js';

declare global {
    const route: typeof routeFn;

    interface Paginator<T> {
        data: T[];
        links: {
            url: string | null;
            label: string;
            active: boolean;
        }[];
        meta: {
            current_page: number;
            from: number | null;
            last_page: number;
            path: string;
            per_page: number;
            to: number | null;
            total: number;
            prev_page_url?: string | null;
            next_page_url?: string | null;
        };
    }
}
