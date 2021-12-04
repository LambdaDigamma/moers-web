import "../css/app.css";
import "./bootstrap";

import { format, formatDistanceToNow } from "date-fns";
import { de } from "date-fns/locale";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress as progress } from "@inertiajs/progress";

import VueClipboard from "vue-clipboard2";
import "leaflet/dist/leaflet.css";
import { Icon } from "leaflet";

import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

progress.init({
    delay: 250,
    includeCSS: true,
    showSpinner: false,
});

import moment from "moment";
// require("moment/locale/de");

// Vue.config.productionTip = false;
// Vue.use(VueClipboard);
// Vue.mixin({ methods: { route: window.route } });
// Vue.mixin(require("./base"));
// Vue.use(require("vue-moment"), {
//     moment,
// });

// delete Icon.Default.prototype._getIconUrl;
// Icon.Default.mergeOptions({
//     iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
//     iconUrl: require("leaflet/dist/images/marker-icon.png"),
//     shadowUrl: require("leaflet/dist/images/marker-shadow.png"),
// });

let app = document.getElementById("app");

createInertiaApp({
    // resolveComponent: (name) => {
    //     const pages = import.meta.glob("./Pages/**/*.vue");
    //     return pages[`./Pages/${name}.vue`]().then((module) => module.default);
    // },
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue");

        return (await pages[`./Pages/${name}.vue`]()).default;
    },
    title: (title) => `${title} | Mein Moers`,
    setup({ el, app, props, plugin }) {
        let createdApp = createApp({
            render: () => h(app, props),
            mounted() {
                window.addEventListener("popstate", () => {
                    this.$inertia.reload({
                        preserveScroll: false,
                        preserveState: false,
                    });
                });
            },
        });
        createdApp.use(plugin);
        // createdApp.use(VCalendar, {});
        createdApp.component("InertiaHead", Head);
        createdApp.component("Head", Head);
        createdApp.component("InertiaLink", Link);
        createdApp.mixin({
            methods: {
                route: window.route,
            },
        });
        // createdApp.mixin(useModal);
        createdApp.config.globalProperties.$filters = {
            moment(value, dateFormat = "dd, DD.MM. HH:mm") {
                if (!(value instanceof Date)) {
                    value = new Date(value);
                }

                if (dateFormat === "from") {
                    return formatDistanceToNow(value, {
                        addSuffix: true,
                        locale: de,
                    });
                }

                return format(value, dateFormat, { locale: de });
            },
        };
        createdApp.mount(el);
    },
});
