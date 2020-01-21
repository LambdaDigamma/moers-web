<template>

    <div>
        <Header
                :href="route('admin.polls.index')"
                previousTitle="Abstimmungen"
                class="mb-8">
            {{ poll.question }}
        </Header>
        <div class="flex flex-wrap">
            <div class="lg:w-1/2">
                <form class="md:mr-4 bg-white dark:bg-gray-700 rounded shadow" @submit.prevent="submit">
                    <h1 class="pt-6 px-6 text-xl md:text-2xl font-semibold dark:text-white">Allgemeine Informationen:</h1>
                    <div class="p-6 flex flex-wrap">
                        <TextInput v-model="form.question" :errors="$page.errors.question" label="Frage" class="w-full"></TextInput>
                        <TextareaInput v-model="form.description" :errors="$page.errors.description" class="mt-3 w-full" label="Beschreibung" />
                    </div>
                    <div class="flex flex-col items-stretch md:flex-row px-6 py-3 md:items-center bg-gray-700 border-t border-grey-500 rounded-b-lg dark:border-gray-600">
                        <button v-if="!poll.is_closed" class="px-3 py-2 rounded-lg font-bold dark:bg-orange-600 dark:text-white" tabindex="-1" type="button" >Abstimmung beenden</button>
                        <button v-if="!poll.deleted_at" class="px-3 py-2 md:ml-3 mt-3 md:mt-0 rounded-lg font-bold dark:bg-red-600 dark:text-white" tabindex="-1" type="button" @click="destroy">Abstimmung löschen</button>
                        <loading-button :loading="sending" class="md:ml-auto mt-3 md:mt-0 px-3 py-2 rounded-lg font-bold text-base dark:text-gray-800 dark:bg-yellow-500" type="submit">Speichern</loading-button>
                    </div>
                </form>
            </div>
            <div class="bg-white dark:bg-gray-700 rounded shadow lg:w-1/2 p-4">
                <h1 class="text-2xl font-semibold dark:text-white">Ergebnisse:</h1>
                <PollResult :votes="this.results.votes" :results="this.results" />
            </div>
        </div>
    </div>

</template>

<script>
    import LayoutAdmin from "@/Shared/LayoutAdmin";
    import TextInput from "@/Shared/TextInput";
    import LoadingButton from "@/Shared/LoadingButton";
    import TextareaInput from "@/Shared/TextareaInput";
    import PollResult from "@/Shared/PollResult";
    import Header from "@/Shared/Admin/Header";

    export default {
        name: "Edit",
        components: {
            PollResult,
            TextareaInput,
            TextInput,
            LoadingButton,
            Header
        },
        layout: LayoutAdmin,
        props: {
            poll: Object,
            results: Object
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    question: this.poll.question,
                    description: this.poll.description,
                },
            }
        },
        methods: {
            submit() {
                this.$inertia
                    .put(this.route('admin.polls.update', this.poll.id), this.form)
                    .then(() => this.sending = false)
            },
            destroy() {

            }
        }
    }
</script>
