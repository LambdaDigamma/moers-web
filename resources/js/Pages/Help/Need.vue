<template>
    <div>
        <header>
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Ich benötige Hilfe!
                </h2>
                <p class="mt-2 text-sm text-gray-700">
                    Wenn du hier nach Hilfe suchst, wird den anderen Nutzern nur
                    angezeigt, in welchem Stadtteil die Hilfe benötigt wird und
                    wie dir geholfen werden kann.<br />
                    Nach der Abwicklung werden alle erhobenen Daten direkt
                    wieder vollständig gelöscht. Lediglich die gesamte Zahl der
                    Hilfen wird anonym gespeichert.
                </p>
            </div>
        </header>
        <div class="mt-4">
            <form @submit.prevent="submit">
                <div class="overflow-hidden rounded-md shadow">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div>
                            <label
                                for="quarter"
                                class="block text-sm font-medium leading-5 text-gray-700"
                            >
                                Stadtteil
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <select-input
                                    id="quarter"
                                    v-model="form.quarter_id"
                                >
                                    <option
                                        v-for="quarter in quarters"
                                        :value="quarter.id"
                                        :key="quarter.id"
                                    >
                                        {{ quarter.name }} ({{
                                            quarter.postcode
                                        }})
                                    </option>
                                </select-input>
                            </div>
                        </div>

                        <div class="mt-4">
                            <TextareaInput
                                label="Wobei benötigst du Hilfe?"
                                placeholder="Gib hier kurz an, wie dir eine andere Person helfen kann..."
                                v-model="form.request"
                                :errors="$page.props.errors.request"
                            >
                            </TextareaInput>
                        </div>

                        <div class="flex items-center mt-4">
                            <Checkbox
                                id="consent"
                                v-model="form.consent"
                            ></Checkbox>
                            <label for="consent" class="ml-3">
                                <span
                                    class="block text-sm font-medium leading-5 text-gray-700"
                                >
                                    Ich bin damit einverstanden, dass ich
                                    kontaktiert werden kann, wenn mir jemand
                                    aktiv helfen will.
                                </span>
                            </label>
                            <!-- <input
                                id="consent"
                                type="checkbox"
                                v-model="form.consent"
                                class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-checkbox"
                            />
                            <label for="consent" class="ml-3">
                                <span
                                    class="block text-sm font-medium leading-5 text-gray-700"
                                >
                                    Ich bin damit einverstanden, dass ich
                                    kontaktiert werden kann, wenn mir jemand
                                    aktiv helfen will.
                                </span>
                            </label> -->
                        </div>
                    </div>
                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button
                                type="submit"
                                :disabled="!form.consent"
                                :class="{ 'opacity-50': !form.consent }"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring-blue active:bg-blue-700"
                            >
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
            <HelpItem
                v-for="(request, index) in activeRequests"
                :key="index"
                :request="request"
                class="my-3"
            />
        </div>
    </div>
</template>

<script>
import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";
import TextInput from "@/Shared/UI/TextInput.vue";
import TextareaInput from "@/Shared/UI/TextareaInput.vue";
import HelpItem from "@/Shared/Help/HelpItem.vue";
import SelectInput from "@/Shared/SelectInput.vue";
import Checkbox from "@/Shared/UI/Checkbox.vue";

export default {
    name: "Need",
    components: { TextareaInput, TextInput, HelpItem, SelectInput, Checkbox },
    layout: LayoutGeneral,
    props: {
        quarters: Array,
        activeRequests: Array,
    },
    data() {
        return {
            form: {
                request: null,
                quarter_id: this.quarters,
                consent: false,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.post(this.route("help.need.store"), this.form);
        },
    },
};
</script>

<style scoped></style>
