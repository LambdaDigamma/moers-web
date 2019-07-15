import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import AuthService from './auth.service';
import { API_URL } from "./config";

const ApiService = {

    init() {
        Vue.use(VueAxios, axios)
        Vue.axios.defaults.baseURL = "/api/v2/"
    },

    setHeader() {

        let csrfToken = document.head.querySelector('meta[name="csrf-token"]')

        if (csrfToken) {
            Vue.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content
        }

        let authToken = AuthService.getToken()

        if (authToken && authToken !== "") {
            Vue.axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`
        }

        Vue.axios.defaults.headers.common['Accept'] = 'application/json'
        Vue.axios.defaults.headers.common['Content-Type'] = 'application/json'
        Vue.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

    },

    query(resource, params) {
        return Vue.axios.get(resource, params).catch(error => {
            throw new Error(`[MM] ApiService ${error}`)
        });
    },

    get(resource, slug = "") {
        return Vue.axios.get(`${resource}/${slug}`).catch(error => {
            throw new Error(`[MM] ApiService ${error}`)
        });
    },

    post(resource, params) {
        return Vue.axios.post(`${resource}`, params)
    },

    update(resource, slug, params) {
        return Vue.axios.put(`${resource}/${slug}`, params)
    },

    put(resource, params) {
        return Vue.axios.put(`${resource}`, params);
    },

    delete(resource) {
        return Vue.axios.delete(resource).catch(error => {
            throw new Error(`[MM] ApiService ${error}`);
        });
    }

}

export default ApiService

export const OrganisationService = {
    get() {
        return ApiService.get("organisations");
    }
}

export const PollService = {
    get() {
        return ApiService.get('polls')
    },
    get(id) {
        return ApiService.get("polls", id);
    }
}

export const EventService = {
    get() {
        return ApiService.get('advEvents')
    }
}