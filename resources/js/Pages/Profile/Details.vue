<template>

    <div class="pb-20">
        <header>
            <div class="mx-auto max-w-7xl">
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
                        <div class="overflow-hidden rounded-md shadow">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="col-span-2 sm:col-span-1">
                                        <TextInput label="Vorname" placeholder="Vorname" v-model="form.first_name" :errors="$page.errors.first_name"
                                                   hint="Nur dein Vorname wird öffentlich angezeigt." />
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <TextInput label="Nachname" placeholder="Nachname" v-model="form.last_name" :errors="$page.errors.last_name" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-6 mt-6">
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
                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
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
                        <div class="overflow-hidden rounded-md shadow">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Exportiere deine persönlichen Daten
                                </h3>
                                <div class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                                    <p>
                                        Du kannst alle personenbezogenen Daten anfordern und erhälst diese dann per E-Mail.
                                    </p>
                                </div>
                                <div class="mt-5">
                                    <inertia-link
                                            method="POST" :href="route('profile.export')"
                                            class="inline-flex items-center justify-center px-4 py-2 font-medium text-blue-700 transition duration-150 ease-in-out bg-blue-100 border border-transparent rounded-md hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-blue-200 sm:text-sm sm:leading-5">
                                        Daten anfordern
                                    </inertia-link>
                                </div>
                            </div>

                        </div>
                    </form>
                    <form action="#" method="POST" class="mt-6">
                        <div class="overflow-hidden rounded-md shadow">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    Lösche dein Benutzerkonto
                                </h3>
                                <div class="max-w-xl mt-2 text-sm leading-5 text-gray-500">
                                    <p>
                                        Sobald du dein Konto löschst, verlierst du alle damit verbundenen Daten.
                                    </p>
                                </div>
                                <div class="mt-5">
                                    <button type="button" @click="showDeletionModal" class="inline-flex items-center justify-center px-4 py-2 font-medium text-red-700 transition duration-150 ease-in-out bg-red-100 border border-transparent rounded-md hover:bg-red-50 focus:outline-none focus:border-red-300 focus:shadow-outline-red active:bg-red-200 sm:text-sm sm:leading-5">
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
                    first_name: this.personalInformation.first_name,
                    last_name: this.personalInformation.last_name,
                    email: this.personalInformation.email,
                    description: this.personalInformation.description,
                },
            }
        },
        methods: {
            submit() {
                this.$inertia
                    .put(this.route('profile.update').url(), this.form)
            },
            showDeletionModal() {
                let r = confirm("Möchtest du dein Benutzerkonto wirklich löschen? Dies kann nicht rückgängig gemacht werden.");
                if (r === true) {
                    this.$inertia.delete(this.route('profile.delete'))
                }
            }
        }
    }
</script>

<style scoped>

</style>