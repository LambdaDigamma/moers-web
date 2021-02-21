const path = require("path");

module.exports = {
    module: {
        rules: [
            {
                resourceQuery: /blockType=i18n/,
                type: "javascript/auto",
                loader: "@intlify/vue-i18n-loader"
            }
        ]
    },
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            'vue$': 'vue/dist/vue.runtime.esm.js',
        },
        modules: [
            "node_modules",
            // __dirname + "/vendor/spatie/laravel-medialibrary-pro/resources/js",
        ]
    },
    // output: {
    //     chunkFilename: '[name].js?id=[chunkhash]'
    // },
};
