import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';
import fs from "fs";
import { watch } from "vite-plugin-watch"

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'vite.dev.test',
            clientPort: 443,
        },
        https: {
            key: fs.readFileSync('/usr/src/app/.infrastructure/conf/traefik/dev/certificates/local-dev-key.pem'),
            cert: fs.readFileSync('/usr/src/app/.infrastructure/conf/traefik/dev/certificates/local-dev.pem'),
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
        // watch({
        //     pattern: ["app/{Data,Dto,Enums}/**/*.php", "Modules/**/*.php"],
        //     command: "php artisan typescript:transform",
        // }),
    ],
    esbuild: {
        jsx: 'automatic',
    },
    resolve: {
        alias: {
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
});
