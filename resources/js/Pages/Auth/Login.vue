<template>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <img class="mx-auto h-64" src="/img/icon.png" alt="Mein Moers Icon" />
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Melde dich mit deinem Account an
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
                    oder
                    <inertia-link :href="route('register')" class="font-medium text-red-600 hover:text-red-500 focus:outline-none focus:underline transition ease-in-out duration-150">
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
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="E-Mail Adresse" />
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password"
                               name="password"
                               type="password"
                               v-model="form.password"
                               required
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort" />
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-red-600 transition duration-150 ease-in-out" />
                        <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                            Angemeldet bleiben
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <inertia-link :href="route('password.request')" class="font-medium text-red-600 hover:text-red-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Passwort vergessen?
                        </inertia-link>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                        <span class="absolute left-0 inset-y pl-3">
                            <svg class="h-5 w-5 text-red-400 group-hover:text-red-300 transition ease-in-out duration-150" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Anmelden
                    </button>
                </div>

                <div v-if="$page.errors" class="mt-3 text-red-500 font-semibold text-sm">
                    <p v-if="$page.errors.email">{{ $page.errors.email[0] }}</p>
                    <p v-if="$page.errors.password">{{ $page.errors.password[0] }}</p>
                </div>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm leading-5">
                        <span class="px-2 bg-gray-50 text-gray-500">
                        oder melde dich an mit
                        </span>
                    </div>
                </div>

                <div class="mt-6" id="appleid-signin">
                    <span class="block w-full rounded-md shadow-sm">
                        <a :href="this.endpoint" class="w-full flex justify-center py-2 px-4 border border-transparent text-base font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700 transition duration-150 ease-in-out">
                             Sign in with Apple
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