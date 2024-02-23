import _ from "lodash";
import axios from "axios";
window._ = _;

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: "pusher",
    key: "d6e230a8246cff590289",
    cluster: "eu",
    encrypted: true,
    forceTLS: true,
});
