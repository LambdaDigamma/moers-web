<template>

    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div>
                <img class="h-64 mx-auto" src="/img/icon.png" alt="Mein Moers Icon" />
                <h2 class="mt-6 text-3xl font-extrabold leading-9 text-center text-gray-900">
                    Melde dich mit deinem Account an
                </h2>
                <p class="mt-2 text-sm leading-5 text-center text-gray-600 max-w">
                    oder
                    <inertia-link :href="route('register')" class="font-medium text-red-600 transition duration-150 ease-in-out hover:text-red-500 focus:outline-none focus:underline">
                        erstelle deinen neuen Account
                    </inertia-link>
                </p>
            </div>
            <form class="mt-8" @submit.prevent="submit">
                <input type="hidden" name="remember" value="true" />
                <div class="rounded-md shadow-sm">
                    <div>
                        <input aria-label="E-Mail Adresse"
                               name="email"
                               type="email"
                               v-model="form.email"
                               required
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="E-Mail Adresse" />
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password"
                               name="password"
                               type="password"
                               v-model="form.password"
                               required
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 text-red-600 transition duration-150 ease-in-out form-checkbox" />
                        <label for="remember_me" class="block ml-2 text-sm leading-5 text-gray-900">
                            Angemeldet bleiben
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <inertia-link :href="route('password.request')" class="font-medium text-red-600 transition duration-150 ease-in-out hover:text-red-500 focus:outline-none focus:underline">
                            Passwort vergessen?
                        </inertia-link>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="relative flex justify-center w-full px-4 py-2 text-base font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md group hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                        <span class="absolute left-0 pl-3 inset-y">
                            <svg class="w-5 h-5 text-red-400 transition duration-150 ease-in-out group-hover:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Anmelden
                    </button>
                </div>

                <div v-if="$page.errors" class="mt-3 text-sm font-semibold text-red-500">
                    <p v-if="$page.errors.email">{{ $page.errors.email[0] }}</p>
                    <p v-if="$page.errors.password">{{ $page.errors.password[0] }}</p>
                </div>

                <div class="relative mt-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm leading-5">
                        <span class="px-2 text-gray-500 bg-gray-50">
                        oder melde dich an mit
                        </span>
                    </div>
                </div>

                <div class="mt-6" id="appleid-signin">
                    <span class="block w-full rounded-md shadow-sm">
                        <a :href="this.endpoint" class="flex justify-center w-full px-4 py-2 text-base font-medium text-white transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded-md hover:bg-gray-800 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700">
                             Sign in with Apple
                        </a>
                    </span>
                </div>

                <div class="mt-4" id="google-signin">
                    <span class="block w-full rounded-md shadow-sm">
                        <a :href="this.googleEndpoint" class="flex items-center justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700">
                            <svg class="w-5 h-5 mr-3 -ml-1" fill="currentColor" viewBox="0 0 488 512">
                                <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                            </svg>
                            Anmelden mit Google
                        </a>
                    </span>
                </div>

            </form>
        </div>
    </div>

</template>

<script>
    import TextInput from "../../Shared/TextInput";
    import Navigation from "../../Shared/Navigation";
    import LoadingButton from "../../Shared/LoadingButton";
    export default {
        name: "Login",
        components: {LoadingButton, Navigation, TextInput},
        props: {
            errors: Object,
            endpoint: String,
            googleEndpoint: String
        },
        data() {
            return {
                sending: false,
                form: {
                    email: '',
                    password: '',
                    remember: null,
                },
            }
        },
        computed: {
            formDisabled() {
                return this.form.email === '' && this.form.password === ''
            }
        },
        methods: {
            submit() {
                this.sending = true
                this.$inertia.post(this.route('login.attempt').url(), {
                    email: this.form.email,
                    password: this.form.password,
                    remember: true
                }).then(() => this.sending = false)
            },
        },
    }
</script>

<style scoped>

</style>