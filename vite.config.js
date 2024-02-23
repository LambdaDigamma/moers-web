import vue from "@vitejs/plugin-vue";
import { nodeResolve } from "@rollup/plugin-node-resolve";
import mkcert from "vite-plugin-mkcert";
import url from "@rollup/plugin-url";
import path from "path";
import fs from 'fs';
import laravel from 'laravel-vite-plugin';
import { exec } from "child_process";
import {defineConfig} from 'vite'
import {homedir} from 'os'
import {resolve} from 'path'

let host = 'mein-moers.localhost'

export default ({ command }) => ({
    base: command === "serve" ? "" : "/build/",
    // publicDir: false,
    // build: {
    //     manifest: true,
    //     outDir: "public/build",
    //     rollupOptions: {
    //         input: "resources/js/app.js",
    //     },
    // },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
            "~": path.resolve(__dirname, "resources/img"),
            ziggy: path.resolve("vendor/tightenco/ziggy/dist/vue"),
        },
    },
    plugins: [
        laravel([
            'resources/js/app.js',
            'resources/css/app.css',
        ]),
        nodeResolve({
            moduleDirectories: [
                "node_modules",
                __dirname +
                    "/vendor/spatie/laravel-medialibrary-pro/resources/js",
            ],
        }),
        url({
            limit: Infinity,
            publicPath: "/public",
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        {
            name: "blade",
            handleHotUpdate({ file, server }) {
                if (file.endsWith(".blade.php")) {
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
        {
            name: "rebuildRoutes",
            handleHotUpdate({ file, server }) {
                if (file.includes("routes") && file.endsWith(".php")) {
                    exec("yarn routes");
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
    ],
    server: detectServerConfig(host),
});

function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
    let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}
