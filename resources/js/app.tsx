import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { configureEcho } from '@laravel/echo-react';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';
import { formatPageTitle } from './lib/seo';

configureEcho({
    broadcaster: 'reverb',
});

createInertiaApp({
    title: formatPageTitle,
    pages: './pages',
    setup({ el, App, props }) {
        if (!el) {
            throw new Error('Inertia root element not found.');
        }

        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
