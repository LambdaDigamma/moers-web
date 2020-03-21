<template>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <img class="mx-auto h-64" src="/img/icon.png" alt="Mein Moers Icon" />
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Passwort zurücksetzen
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
                    Gib dein neues Passwort ein und bestätige es.
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
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort" />
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password bestätigen"
                               name="password_confirmation"
                               type="password"
                               v-model="form.password_confirmation"
                               required
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                               placeholder="Passwort bestätigen" />
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                        <span class="absolute left-0 inset-y pl-3">
                            <svg class="h-5 w-5 text-red-400 group-hover:text-red-300 transition ease-in-out duration-150" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Passwort ändern
                    </button>
                </div>

                <div v-if="$page.errors" class="mt-3 text-red-500 font-semibold text-sm">
                    <p v-if="$page.errors.email">{{ $page.errors.email[0] }}</p>
                    <p v-if="$page.errors.password">{{ $page.errors.password[0] }}</p>
                    <p v-if="$page.errors.password_confirmation">{{ $page.errors.password_confirmation[0] }}</p>
                </div>

            </form>
        </div>
    </div>


</template>

<script>
    export default {
        name: "ResetPassword",
        remember: 'form',
        props: {
            email: String,
            token: String
        },
        data() {
            return {
                form: {
                    email: this.email,
                    token: this.token,
                    password: null,
                    password_confirmation: null
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('password.update'), this.form)
            }
        }
    }
</script>

<style scoped>

</style>