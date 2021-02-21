<template>

    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-50 sm:px-6 lg:px-8">

        <div class="w-full max-w-md">
            <div>
                <img class="h-64 mx-auto" src="/img/icon.png" alt="Mein Moers Icon" />
                <h2 class="mt-6 text-3xl font-extrabold leading-9 text-center text-gray-900">
                    Passwort zurücksetzen
                </h2>
                <p class="mt-2 text-sm leading-5 text-center text-gray-600 max-w">
                    Gib deine E-Mail Adresse ein, um dein Passwort zurückzusetzen.
                    Du erhältst dann eine E-Mail, in der du einen Zurücksetzungslink findest.
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
                               class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="E-Mail Adresse" />
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="relative flex justify-center w-full px-4 py-2 text-base font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md group hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring-red active:bg-red-700">
                        <span class="absolute left-0 pl-3 inset-y">
                            <svg class="w-5 h-5 text-red-400 transition duration-150 ease-in-out group-hover:text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </span>
                        Zurücksetzungslink anfordern
                    </button>
                </div>

                <div v-if="$page.errors" class="mt-3 text-sm font-semibold text-red-500">
                    <p v-if="$page.errors.email">{{ $page.errors.email[0] }}</p>
                </div>

            </form>
            <FlashMessages class="mx-auto mt-4" />
        </div>
    </div>

</template>

<script>
    import FlashMessages from "../../Shared/FlashMessages";

    export default {
        name: "SendResetMail",
        components: {FlashMessages},
        data() {
            return {
                form: {
                    email: null
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('password.email'), {
                    email: this.form.email
                })
            }
        }
    }
</script>

<style scoped>

</style>