<template>

    <div>
        <header>
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Profil
                </h2>
            </div>
        </header>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Persönliche Informationen</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Diese Informationen werden mit Vorsicht behandelt.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submit">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <TextInput label="Name" placeholder="Name" v-model="form.name" :errors="$page.errors.name"
                                                   hint="Hier wird nur dein Vorname angezeigt." />
                                    </div>
                                </div>
                                <div class="mt-6 grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <TextInput label="E-Mail" placeholder="E-Mail" v-model="form.email" :errors="$page.errors.email" :disabled="personalInformation.canChangeEmail" />
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <TextareaInput
                                            label="Beschreibung"
                                            placeholder="Beschreibung"
                                            hint="Eine kurze Beschreibung für dein Profil."
                                            v-model="form.description"
                                            :is-optional="true"
                                            :errors="$page.errors.description" />
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                                        Speichern
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden sm:block">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Datenschutz</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Exportiere alle Daten, die wir über dich haben oder lösche dein Benutzerkonto.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Exportiere deine persönlichen Daten
                                </h3>
                                <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                                    <p>
                                        Du kannst alle personenbezogenen Daten anfordern und erhälst diese dann per E-Mail.
                                    </p>
                                </div>
                                <div class="mt-5">
                                    <inertia-link
                                            method="POST" :href="route('profile.export')"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200 transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Daten anfordern
                                    </inertia-link>
                                </div>
                            </div>

                        </div>
                    </form>
                    <form action="#" method="POST" class="mt-6">
                        <div class="shadow sm:rounded-md sm:overflow-hidden opacity-50">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Lösche dein Benutzerkonto
                                </h3>
                                <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                                    <p>
                                        Sobald du dein Konto löschst, verlierst du alle damit verbundenen Daten.
                                    </p>
                                </div>
                                <div class="mt-5">
                                    <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-50 focus:outline-none focus:border-red-300 focus:shadow-outline-red active:bg-red-200 transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Benutzerkonto löschen
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import TextInput from "../../Shared/TextInput";
    import TextareaInput from "../../Shared/TextareaInput";
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";

    export default {
        name: "Details",
        components: {TextareaInput, TextInput},
        layout: LayoutGeneral,
        metaInfo: {
            title: 'Profil'
        },
        props: {
            personalInformation: Object
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    name: this.personalInformation.name,
                    email: this.personalInformation.email,
                    description: this.personalInformation.description,
                },
            }
        },
        methods: {
            submit() {
                this.$inertia
                    .put(this.route('profile.update').url(), this.form)
            }
        }
    }
</script>

<style scoped>

</style>