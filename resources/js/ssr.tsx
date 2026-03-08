import { createInertiaApp } from '@inertiajs/react';
import { type RouteName, route } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    pages: './pages',
    setup: ({ App, props }) => {
        const page = props.initialPage;

        /* eslint-disable */
        // @ts-expect-error
        global.route<RouteName> = (name, params, absolute) =>
            route(name, params as any, absolute, {
                // @ts-expect-error
                ...page.props.ziggy,
                // @ts-expect-error
                location: new URL(page.props.ziggy.location),
            });
        /* eslint-enable */

        return <App {...props} />;
    },
});
