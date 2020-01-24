<template>

    <div>
        <Navigation></Navigation>
        <div class="">
            <div class="w-full max-w-sm mx-auto z-10">
                <form class="bg-gray-100 dark:bg-gray-700 shadow-md rounded px-4 pt-4 pb-8 mb-4" @submit.prevent="submit">
                    <h1 class="dark:text-gray-100 font-semibold text-center">Anmelden</h1>
                    <div class="mt-4 mb-2">
                        <TextInput
                            class="shadow appearance-none rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-white focus:text-white"
                            label="E-Mail"
                            placeholder="E-Mail"
                            type="email"
                            :errors="$page.errors.email"
                            v-model="form.email" />
                    </div>
                    <div class="mb-6">
                        <TextInput
                                class="shadow appearance-none rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-white focus:text-white"
                                label="Passwort"
                                placeholder="Passwort"
                                type="password"
                                :errors="$page.errors.password"
                                v-model="form.password" />
                    </div>
                    <div class="flex flex-col">
                        <LoadingButton :loading="sending" :disabled="formDisabled" class="h-10 bg-blue-500 hover:bg-blue-700 text-gray-100 dark:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline dark:bg-yellow-500 dark-hover:bg-yellow-600">
                            Anmelden
                        </LoadingButton>
                        <a class="mt-3 inline-block align-baseline font-semibold text-sm text-gray-200 hover:text-gray-200" href="/password/reset">
                            Passwort vergessen?
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="absolute fill-current z-0 text-gray-600 mb-0 bottom-0 w-full">
            <svg class="w-full fill-current" viewBox="0 0 3840 2160" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="1.5">
                <path fill="none" d="M0 0h3840v2160H0z"/>
                <clipPath id="a">
                    <path d="M0 0h3840v2160H0z"/>
                </clipPath>
                <g clip-path="url(#a)" fill="fillCurrent">
                    <path d="M3295.82 870.611c-.444-.605-2.707-4.598-9.75-17.68-14.725-27.352-17.249-33.527-16.395-56.313.855-22.787 21.98-33.142 29.226-36.354 7.246-3.213 40.174-3.858 54.888 8.554 14.714 12.412 18.127 19.689 26.375 28.513 8.247 8.824 15.682 8.554 15.682 8.554l14.617 8.554s-10.394 4.858-15.33 4.989c-4.936.132-21.827 4.6-34.216-20.672-12.388-25.271-39.725-25.466-42.77-25.661-3.044-.196-27.076-5.465-32.79 18.533-5.713 23.998 1.894 34.433 9.98 49.185 8.086 14.753 16.584 20.933 14.257 37.78-2.328 16.847-12.025 19.511-17.108 24.949-5.084 5.439-11.504 9.482-5.703 33.503 5.801 24.022 27.088 16.395 27.088 16.395 4.113-5.051 9.897-6.018 14.543-5.702 4.646.315 14.932 4.449 15.395 14.969.464 10.52-5.702 12.831-5.702 12.831l2.735 7.656c55.071 1.383 97.629 10.354 97.629 21.199l52.559 488.621.224.038c19.472 3.322 28.718 9.312 28.718 13.544 0 4.036-7.222 9.841-25.052 13.08l16.404 119.506v80.55h-23.523v444.549h-323.625v-444.549h-19.246v-80.55l13.15-119.506c-17.83-3.239-26.075-9.044-26.075-13.08 0-4.232 9.247-10.222 28.719-13.544l.224-.038 52.558-488.621c0-11.186 45.276-20.378 102.859-21.307l1.07-7.548-3.564-5.703c-36.737.331-34.611-12.142-41.304-32.79-6.693-20.647-.41-27.181 2.811-34.216 3.22-7.034 10.198-10.03 17.108-19.246 4.224-5.635 4.082-10.243 3.334-12.972zm-113.716 652.335l-12.503 116.236h34.203l5.85-114.015c-9.943-.62-19.168-1.356-27.55-2.221zm187.084 4.743a2836.14 2836.14 0 01-31.081.271v111.222h31.081v-111.493zm48.93-1.29c-7.923.324-16.17.593-24.693.811v111.972h30.48l-5.787-112.783zm-135.329 1.29v111.493h31.082V1527.96c-10.61-.037-20.993-.125-31.082-.271zm187.084-4.743c-8.381.865-17.607 1.601-27.55 2.221l5.85 114.015h34.203l-12.503-116.236zm-236.014 3.453l-5.787 112.783h30.481V1527.21a1618.68 1618.68 0 01-24.694-.811zm232.455-36.546l-49.341-458.705 23.436 456.718c9.274.557 17.942 1.216 25.905 1.987zm-254.746-1.987l23.436-456.718-49.34 458.705c7.962-.771 16.63-1.43 25.904-1.987zm46.985-1.906v-440.788l-22.655 441.506c7.296-.284 14.859-.522 22.655-.718zm157.527.718l-22.655-441.506v440.788c7.795.196 15.358.434 22.655.718zm-133.291-462.536v461.351c10.089-.142 20.472-.226 31.082-.262v-459.576c-10.901-.222-21.338-.741-31.082-1.513zm86.399 0c-9.744.772-20.181 1.291-31.081 1.513v459.576c10.609.036 20.992.12 31.081.262v-461.351zm-73.559-154.154c-.456-1.343-1.005-2.087-1.005-2.087s.628 1.259 1.005 2.087c.066.195.13.403.191.623.188.257.049-.096-.191-.623z"/>
                    <path d="M3183.57 1719.73h13.829v444.549h-13.829zM3217.45 1719.73h13.829v444.549h-13.829zM3251.32 1719.73h13.829v444.549h-13.829zM3285.19 1719.73h13.829v444.549h-13.829zM3319.07 1719.73h13.829v444.549h-13.829zM3352.94 1719.73h13.829v444.549h-13.829zM3386.82 1719.73h13.829v444.549h-13.829zM3420.69 1719.73h13.829v444.549h-13.829zM3454.57 1719.73h13.829v444.549h-13.829zM3144.93 1639.18h366.394v80.55H3144.93z"/>
                    <g>
                        <circle cx="446.494" cy="525.509" r="13.711"/>
                        <path d="M446.494 392.571v119.227-89.421h23.25H423.245" stroke="#231f20" stroke-width="4"/>
                        <path d="M446.399 534.629l-67.268 615.032-17.884 9.538v375.565h-7.153v76.305H209.829L42.912 1794.678h10.73v369.603h784.513v-388.679H862l-171.687-122.804v-11.922l13.115-13.115-27.422-13.115-118.034-110.881v-340.989l-29.807-15.499-81.766-612.648z"/>
                    </g>
                    <path d="M1009.95 1706h35.727v227.518l67.218 58.357V1902.5l102.946 89.375V1902.5l85.109 73.89V1706h35.727v454H907.005v-257.5l102.945 89.375V1706zM1492.67 2047v113h-111v-113l55.5-76.711 55.5 76.711zM1603.67 2047v113h-111v-113l55.5-76.711 55.5 76.711zM1714.67 2047v113h-111v-113l55.5-76.711 55.5 76.711z"/>
                </g>
            </svg>
        </div>
    </div>



<!--    <div class="p-6 bg-indigo-darker min-h-screen flex justify-center items-center">-->
<!--        <div class="w-full max-w-sm">-->
<!--            <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">-->
<!--                <div class="px-10 py-12">-->
<!--                    <h1 class="text-center font-bold text-2xl">Mein Moers</h1>-->
<!--                    <div class="mx-auto mt-6 w-24 border-b-2" />-->
<!--                    <text-input v-model="form.email" :errors="$page.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />-->
<!--                    <text-input v-model="form.password" class="mt-6" label="Password" type="password" />-->
<!--                    <label class="mt-6 select-none flex items-center" for="remember">-->
<!--                        <input id="remember" v-model="form.remember" class="mr-1" type="checkbox">-->
<!--                        <span class="text-sm">Remember Me</span>-->
<!--                    </label>-->
<!--                </div>-->
<!--                <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-between items-center">-->
<!--                    <a class="hover:underline" tabindex="-1" href="#reset-password">Forget password?</a>-->
<!--&lt;!&ndash;                    <loading-button :loading="sending" class="btn-indigo" type="submit">Login</loading-button>&ndash;&gt;-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->

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
                this.$inertia.post(this.route('login.attempt'), {
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