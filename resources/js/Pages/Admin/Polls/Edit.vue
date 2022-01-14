<template>
    <div>
        <Header
            :href="route('admin.polls.index')"
            previousTitle="Abstimmungen"
            class="mb-8"
        >
            {{ poll.question }}
        </Header>

        <FormColumnPanel method="PUT" @save="updateEntry">
            <div slot="description">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Frage
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    Bearbeite die Frage und Antwortmöglichkeiten der Abstimmung.
                </p>
            </div>
            <div>
                <div class="grid grid-cols-6 gap-6">
                    <TextInput
                        class="col-span-6 sm:col-span-4"
                        v-model="form.question"
                        label="Frage"
                        placeholder="Frage"
                        :errors="$page.errors.question"
                    >
                    </TextInput>
                    <TextareaInput
                        class="col-span-6 sm:col-span-4"
                        v-model="form.description"
                        label="Beschreibung"
                        placeholder="Beschreibung"
                        :errors="$page.errors.description"
                    />
                </div>
            </div>
        </FormColumnPanel>

        <Panel class="mt-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Aktionen
                    </h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Administriere die Abstimmung.
                    </p>
                </div>
                <div class="space-y-6 md:col-span-2">
                    <form v-if="!poll.is_closed" action="#" method="POST">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Beende diese Abstimmung
                        </h3>
                        <div
                            class="max-w-xl mt-2 text-sm leading-5 text-gray-500"
                        >
                            <p>
                                Wenn du die Abstimmung beendest, kann niemand
                                mehr teilnehmen und die Ergebnisse stehen fest.
                            </p>
                        </div>
                        <div class="mt-5">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center px-4 py-2 font-medium text-blue-700 transition duration-150 ease-in-out bg-blue-100 border border-transparent rounded-md hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-blue-200 sm:text-sm sm:leading-5"
                            >
                                Abstimmung beenden
                            </button>
                        </div>
                    </form>
                    <form v-if="!poll.deleted_at" action="#" method="POST">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Lösche diese Abstimmung
                        </h3>
                        <div
                            class="max-w-xl mt-2 text-sm leading-5 text-gray-500"
                        >
                            <p>
                                Wenn die Abstimmung gelöscht wird, werden auch
                                alle Abstimmungsergebnisse vernichtet.
                            </p>
                        </div>
                        <div class="mt-5">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center px-4 py-2 font-medium text-red-700 transition duration-150 ease-in-out bg-red-100 border border-transparent rounded-md hover:bg-red-50 focus:outline-none focus:border-red-300 focus:ring-red active:bg-red-200 sm:text-sm sm:leading-5"
                            >
                                Abstimmung löschen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Panel>

        <Panel class="mt-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Ergebnisse
                    </h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Administriere die Abstimmung.
                    </p>
                </div>
                <div class="md:col-span-2">
                    <PollResult
                        :votes="this.results.votes"
                        :results="this.results"
                    />
                </div>
            </div>
        </Panel>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import TextInput from "@/Shared/UI/TextInput.vue";
import LoadingButton from "@/Shared/UI/LoadingButton.vue";
import TextareaInput from "@/Shared/UI/TextareaInput.vue";
import PollResult from "@/Shared/PollResult.vue";
import Header from "@/Shared/Admin/Header.vue";
import FormColumnPanel from "@/Shared/UI/Panels/FormColumnPanel.vue";
import Panel from "@/Shared/UI/Panels/Panel.vue";

export default {
    name: "Edit",
    components: {
        Panel,
        FormColumnPanel,
        PollResult,
        TextareaInput,
        TextInput,
        LoadingButton,
        Header,
    },
    layout: LayoutAdmin,
    props: {
        poll: Object,
        results: Object,
    },
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                question: this.poll.question,
                description: this.poll.description,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.put(
                this.route("admin.polls.update", this.poll.id),
                this.form,
                {
                    onSuccess: () => {
                        this.sending = false;
                    },
                }
            );
        },
        destroy() {},
    },
};
</script>
