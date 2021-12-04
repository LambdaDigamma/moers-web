import vue from "@vitejs/plugin-vue";
import { nodeResolve } from "@rollup/plugin-node-resolve";
import mkcert from "vite-plugin-mkcert";
import url from "@rollup/plugin-url";
import path from "path";
import { exec } from "child_process";

export default ({ command }) => ({
    base: command === "serve" ? "" : "/build/",
    publicDir: false,
    build: {
        manifest: true,
        outDir: "public/build",
        rollupOptions: {
            input: "resources/js/app.js",
        },
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
            "~": path.resolve(__dirname, "resources/img"),
            ziggy: path.resolve("vendor/tightenco/ziggy/dist/vue"),
        },
    },
    plugins: [
        mkcert({
            autoUpgrade: true,
        }),
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
        vue(),
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
});
