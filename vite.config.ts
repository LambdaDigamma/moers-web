import inertia from '@inertiajs/vite';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';
// import { watch } from 'vite-plugin-watch';

export default defineConfig(({ command }) => {
    const devKeyPath = '/usr/src/app/.infrastructure/conf/traefik/dev/certificates/local-dev-key.pem';
    const devCertPath = '/usr/src/app/.infrastructure/conf/traefik/dev/certificates/local-dev.pem';
    const useHttpsDevServer = command === 'serve' && fs.existsSync(devKeyPath) && fs.existsSync(devCertPath);

    return {
        server: useHttpsDevServer
            ? {
                  host: '0.0.0.0',
                  hmr: {
                      host: 'vite.dev.test',
                      clientPort: 443,
                  },
                  https: {
                      key: fs.readFileSync(devKeyPath),
                      cert: fs.readFileSync(devCertPath),
                  },
              }
            : undefined,
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.tsx'],
                ssr: 'resources/js/ssr.tsx',
                refresh: true,
            }),
            inertia({
                ssr: 'resources/js/ssr.tsx',
            }),
            react(),
            tailwindcss(),
            // watch({
            //     pattern: ['app/{Data,Dto,Enums}/**/*.php', 'Modules/**/*.php'],
            //     command: 'php artisan typescript:transform',
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
    };
});
