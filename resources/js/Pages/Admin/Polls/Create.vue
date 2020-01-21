<template>
    <div>
        <Header
                :href="route('admin.polls.index')"
                previousTitle="Abstimmungen"
                class="mb-8">
            Erstellen
        </Header>
        <div class="rounded shadow bg-white dark:bg-gray-700 max-w-4xl">
            <form @submit.prevent="submit">
                <div class="p-6 flex flex-wrap">
                    <TextInput
                            v-model="form.question"
                            label="Frage"
                            class="w-full"
                            :errors="$page.errors.question" />
                    <TextareaInput
                            v-model="form.description"
                            label="Beschreibung"
                            class="mt-3 w-full"
                            :errors="$page.errors.description" />
                    <SelectInput
                            v-model="form.group_id"
                            class="mt-3 w-full"
                            label="Gruppe"
                            :errors="$page.errors.group_id">
                        <option v-for="group in this.groups" :value="group.id" :key="group.id">
                            {{ group.organisation.name }} • {{ group.name }}
                        </option>
                    </SelectInput>
                    <NumberInput
                            v-model="form.max_check"
                            label="Anzahl der auswählbaren Antworten"
                            class="mt-3 w-full"
                            :min="1"
                            :errors="$page.errors.max_check" />
                    <div class="mt-3 w-full">
                        <span class="font-semibold dark:text-white">Antwortmöglichkeiten:</span>

                        <div v-for="(option, index) in form.options"
                             :key="index" class="mt-2 p-2 w-full flex items-stretch rounded dark:bg-gray-800">

                            <TextInput placeholder="Titel der Antwortmöglichkeit eingeben."
                                       v-model="form.options[index]"
                                       class="flex-grow-1" />

                            <button v-if="canDelete"
                                    class="flex-grow-0 ml-2 font-semibold text-sm px-2 py-1 rounded dark:bg-red-600 dark:text-white"
                                    @click="deletePollOption(index)">
                                    Löschen
                            </button>

                        </div>

                        <span v-if="$page.errors.options"
                              class="font-medium dark:text-red-600">
                            {{ $page.errors.options[0] }}
                        </span>

                        <button @click="addPollOption" class="flex-grow-1 flex-md-grow-0 px-3 py-2 mt-3 ml-1 md:ml-0 rounded font-semibold text-base dark:bg-yellow-500 dark:text-gray-800">
                            Weitere Antwortmöglichkeit hinzufügen
                        </button>

                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-700 border-t border-grey-500 flex items-center rounded-b-lg dark:border-gray-600">
                    <LoadingButton
                            class="px-3 py-2 rounded-lg font-bold text-base dark:bg-green-600 dark:text-white"
                            type="submit"
                            :disabled="!isSubmitEnabled || $page.errors === null"
                            :loading="sending">
                        Abstimmung erstellen
                    </LoadingButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import LayoutAdmin from "@/Shared/LayoutAdmin";
    import LoadingButton from "@/Shared/LoadingButton";
    import SelectInput from "@/Shared/SelectInput";
    import Header from "@/Shared/Admin/Header";
    import TextInput from "../../../Shared/TextInput";
    import NumberInput from "../../../Shared/NumberInput";

    export default {
        name: "Create",
        components: {
            Header,
            LoadingButton,
            SelectInput,
            TextInput,
            NumberInput
        },
        props: {
            groups: Array
        },
        layout: LayoutAdmin,
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    question: null,
                    description: null,
                    group_id: null,
                    max_check: 1,
                    options: ['', ''],
                },
            }
        },
        computed: {
            canDelete() {
                return this.form.options.length > 2
            },
            isSubmitEnabled() {
                if (this.form.question === null || this.form.question === "") {
                    return false
                }
                if (this.form.description === null || this.form.description === "") {
                    return false
                }
                if (this.form.group_id === null) {
                    return false
                }
                if (this.form.max_check < 1 || this.form.max_check >= this.form.options.length) {
                    return false
                }
                for (let i = 0; i < this.form.options.length; i++) {
                    if (this.form.options[i] === '') {
                        return false
                    }
                }
                return true
            }
        },
        methods: {
            submit() {
                this.sending = true
                this.$inertia
                    .post(this.route('admin.polls.store'), this.form)
                    .then(() => this.sending = false)
            },
            addPollOption() {
                this.form.options.push('')
            },
            deletePollOption(index) {
                this.form.options.splice(index, 1)
            },
        }
    }
</script>

<style scoped>

</style>