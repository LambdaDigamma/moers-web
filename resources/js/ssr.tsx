import { createInertiaApp } from '@inertiajs/react';
import createServer from "@inertiajs/react/server";
import ReactDOMServer from 'react-dom/server';
import { type RouteName, route } from 'ziggy-js';
import { TooltipProvider } from '@/components/ui/tooltip';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer((page) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        title: (title) => (title ? `${title} - ${appName}` : appName),
        pages: './pages',
        setup: ({ App, props }) => {

            const initialPage = props.initialPage;

            /* eslint-disable */
            // @ts-expect-error
            global.route<RouteName> = (name, params, absolute) =>
                route(name, params as any, absolute, {
                    // @ts-expect-error
                    ...initialPage.props.ziggy,
                    // @ts-expect-error
                    location: new URL(initialPage.props.ziggy.location),
                });
            /* eslint-enable */

            return (
                <TooltipProvider delayDuration={0}>
                    <App {...props} />
                </TooltipProvider>
            );
        },
    }),
);
