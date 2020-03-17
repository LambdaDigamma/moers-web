<template>

    <div>
        <header>
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Ich benötige Hilfe!
                </h2>
                <p class="mt-2 text-gray-700 text-sm">
                    Wenn du hier nach Hilfe suchst, wird den anderen Nutzern nur angezeigt, in welchem Stadtteil die Hilfe benötigt wird und wie dir geholfen werden kann.<br />
                    Nach der Abwicklung werden alle erhobenen Daten direkt wieder vollständig gelöscht. Lediglich die gesamte Zahl der Hilfen wird anonym gespeichert.
                </p>
            </div>
        </header>
        <div class="mt-4">
            <form @submit.prevent="submit">
                <div class="shadow rounded-md overflow-hidden">
                    <div class="px-4 py-5 bg-white sm:p-6">

                        <div>
                            <label for="quarter" class="block text-sm font-medium leading-5 text-gray-700">
                                Stadtteil
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <select id="quarter" class="form-select block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="form.quarter_id">
                                    <option v-for="quarter in quarters" :value="quarter.id" :key="quarter.id">{{ quarter.name }} ({{ quarter.postcode }})</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <TextareaInput
                                label="Wobei benötigst du Hilfe?"
                                placeholder="Gib hier kurz an, wie dir eine andere Person helfen kann..."
                                v-model="form.request"
                                :errors="$page.errors.request">

                            </TextareaInput>
                        </div>

                        <div class="mt-4 flex items-center">
                            <input id="consent" type="checkbox" v-model="form.consent" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" />
                            <label for="consent" class="ml-3">
                                <span class="block text-sm leading-5 font-medium text-gray-700">
                                    Ich bin damit einverstanden, dass ich kontaktiert werden kann, wenn mir jemand aktiv helfen will.
                                </span>
                            </label>
                        </div>


                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="submit" :disabled="!form.consent" :class="{ 'opacity-50' : !form.consent }"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                                Hilfe suchen
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>

        <div v-if="activeRequests && activeRequests.length !== 0" class="mt-12">

            <h1 class="mb-6 text-3xl font-bold leading-tight text-gray-900">
                Hier benötigst du Hilfe:
            </h1>

            <HelpItem v-for="(request, index) in activeRequests" :key="index" :request="request" class="my-3" />

        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import TextInput from "../../Shared/TextInput";
    import TextareaInput from "../../Shared/TextareaInput";

    export default {
        name: "Need",
        components: {TextareaInput, TextInput},
        layout: LayoutGeneral,
        props: {
            quarters: Array,
            activeRequests: Array
        },
        data() {
            return {
                form: {
                    request: null,
                    quarter_id: this.quarters,
                    consent: false
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('help.need.store'), this.form)
            }
        }
    }
</script>

<style scoped>

</style>