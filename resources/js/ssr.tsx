import { TooltipProvider } from '@/components/ui/tooltip';
import { createInertiaApp, type ResolvedComponent } from '@inertiajs/react';
import createServer from '@inertiajs/react/server';
import ReactDOMServer from 'react-dom/server';
import { route, type RouteName } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pages = import.meta.glob<{ default: ResolvedComponent }>('./pages/**/*.tsx', { eager: true });

type ZiggyProps = {
    ziggy?: {
        location?: string;
    } & Record<string, unknown>;
};

createServer((page) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        title: (title) => (title ? `${title} - ${appName}` : appName),
        resolve: (name) => {
            const resolvedPage = pages[`./pages/${name}.tsx`];

            if (!resolvedPage) {
                throw new Error(`Page not found: ${name}`);
            }

            return resolvedPage;
        },
        setup: ({ App, props }) => {
            const initialPage = props.initialPage;
            const ziggy = (initialPage.props as ZiggyProps).ziggy;

            if (!ziggy || typeof ziggy.location !== 'string') {
                throw new Error('Ziggy page props are missing from the SSR payload.');
            }

            const location = ziggy.location;
            const configuredRoute = ((name: RouteName | undefined, params?: unknown, absolute?: boolean) =>
                route(name as never, params as never, absolute, {
                    ...ziggy,
                    location: new URL(location),
                } as never)) as typeof route;

            (globalThis as typeof globalThis & { route: typeof route }).route = configuredRoute;

            return (
                <TooltipProvider delayDuration={0}>
                    <App {...props} />
                </TooltipProvider>
            );
        },
    }),
);
