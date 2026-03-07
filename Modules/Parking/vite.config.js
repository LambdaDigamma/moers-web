import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'node:url';

const moduleDir = fileURLToPath(new URL('.', import.meta.url));

export default defineConfig({
    build: {
        outDir: '../../public/build-parking',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-parking',
            input: [
                `${moduleDir}resources/assets/sass/app.scss`,
                `${moduleDir}resources/assets/js/app.js`,
            ],
            refresh: true,
        }),
    ],
});
