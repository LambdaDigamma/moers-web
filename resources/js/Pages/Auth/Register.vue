<template>

    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div>
                <img class="h-64 mx-auto" src="/img/icon.png" alt="Mein Moers Icon" />
                <h2 class="mt-6 text-3xl font-extrabold leading-9 text-center text-gray-900">
                    Erstelle deinen neuen Account
                </h2>
                <p class="mt-2 text-sm leading-5 text-center text-gray-600 max-w">
                    oder
                    <inertia-link :href="route('login')" class="font-medium text-red-600 transition duration-150 ease-in-out hover:text-red-500 focus:outline-none focus:underline">
                        melde dich mit deinem Account an
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
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="E-Mail Adresse" />
                    </div>
                    <div class="flex -mt-px">
                        <div class="flex-1 w-1/2 min-w-0">
                            <input aria-label="Vorname"
                                   v-model="form.first_name"
                                   required
                                   class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                                   placeholder="Vorname" />
                        </div>
                        <div class="flex-1 min-w-0 -ml-px">
                            <input aria-label="Nachname"
                                   v-model="form.last_name"
                                   required
                                   class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                                   placeholder="Nachname" />
                        </div>
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password"
                               name="password"
                               type="password"
                               v-model="form.password"
                               required
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort" />
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password bestätigen"
                               name="password_confirmation"
                               type="password"
                               v-model="form.password_confirmation"
                               required
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort bestätigen" />
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="relative flex justify-center w-full px-4 py-2 text-base font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md group hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring-red active:bg-red-700">
                        <span class="absolute left-0 pl-3 inset-y">
                            <svg class="w-5 h-5 text-red-400 transition duration-150 ease-in-out group-hover:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Registrieren
                    </button>
                </div>

                <div v-if="$page.errors" class="mt-3 text-sm font-semibold text-red-500">
                    <p v-if="$page.errors.email">{{ $page.errors.email[0] }}</p>
                    <p v-if="$page.errors.first_name">{{ $page.errors.first_name[0] }}</p>
                    <p v-if="$page.errors.last_name">{{ $page.errors.last_name[0] }}</p>
                    <p v-if="$page.errors.password">{{ $page.errors.password[0] }}</p>
                    <p v-if="$page.errors.password_confirmation">{{ $page.errors.password_confirmation[0] }}</p>
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
                        <a :href="this.endpoint" class="flex justify-center w-full px-4 py-2 text-base font-medium text-white transition duration-150 ease-in-out bg-gray-900 border border-transparent rounded-md hover:bg-gray-800 focus:outline-none focus:border-gray-700 focus:ring-gray active:bg-gray-700">
                             Sign up with Apple
                        </a>
                    </span>
                </div>

                <div class="mt-4" id="google-signin">
                    <span class="block w-full rounded-md shadow-sm">
                        <a :href="this.googleEndpoint" class="flex items-center justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700">
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
    import TextInput from "../../Shared/UI/TextInput";
    import Navigation from "../../Shared/Navigation";
    import LoadingButton from "../../Shared/UI/LoadingButton";
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
                    first_name: '',
                    last_name: '',
                    password: '',
                    password_confirmation: '',
                    remember: null,
                },
            }
        },
        computed: {
            formDisabled() {
                return this.form.email === ''
                    && this.form.password === ''
                    && this.form.first_name === ''
                    && this.form.last_name === ''
                    && this.form.password_confirmation === ''
            }
        },
        methods: {
            submit() {
                this.sending = true
                this.$inertia.post(this.route('register.attempt'), {
                    email: this.form.email,
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                    remember: true
                }).then(() => this.sending = false)
            },
        },
    }
</script>

<style scoped>

</style>