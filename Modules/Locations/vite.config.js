import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'node:url';

const moduleDir = fileURLToPath(new URL('.', import.meta.url));

export default defineConfig({
    build: {
        outDir: '../../public/build-locations',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-locations',
            input: [
                `${moduleDir}resources/assets/sass/app.scss`,
                `${moduleDir}resources/assets/js/app.js`,
            ],
            refresh: true,
        }),
    ],
});
