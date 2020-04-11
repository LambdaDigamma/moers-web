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
                <form class="bg-white rounded shadow md:mr-4 dark:bg-gray-700" @submit.prevent="submit">
                    <h1 class="px-6 pt-6 text-xl font-semibold md:text-2xl dark:text-white">Allgemeine Informationen:</h1>
                    <div class="flex flex-wrap p-6">
                        <TextInput v-model="form.question" :errors="$page.errors.question" label="Frage" class="w-full"></TextInput>
                        <TextareaInput v-model="form.description" :errors="$page.errors.description" class="w-full mt-3" label="Beschreibung" />
                    </div>
                    <div class="flex flex-col items-stretch px-6 py-3 bg-gray-700 border-t rounded-b-lg md:flex-row md:items-center border-grey-500 dark:border-gray-600">
                        <button v-if="!poll.is_closed" class="px-3 py-2 font-semibold rounded-lg dark:bg-orange-600 dark:text-white" tabindex="-1" type="button" >Abstimmung beenden</button>
                        <button v-if="!poll.deleted_at" class="px-3 py-2 mt-3 font-semibold rounded-lg md:ml-3 md:mt-0 dark:bg-red-600 dark:text-white" tabindex="-1" type="button" @click="destroy">Abstimmung löschen</button>
                        <loading-button :loading="sending" class="px-3 py-2 mt-3 text-base font-semibold rounded-lg md:ml-auto md:mt-0 dark:text-gray-800 dark:bg-yellow-500" type="submit">Speichern</loading-button>
                    </div>
                </form>
            </div>
            <div class="p-4 bg-white rounded shadow dark:bg-gray-700 lg:w-1/2">
                <h1 class="text-2xl font-semibold dark:text-white">Ergebnisse:</h1>
                <PollResult :votes="this.results.votes" :results="this.results" />
            </div>
        </div>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import TextInput from "../../../Shared/UI/TextInput";
    import LoadingButton from "../../../Shared/UI/LoadingButton";
    import TextareaInput from "../../../Shared/UI/TextareaInput";
    import PollResult from "../../../Shared/PollResult";
    import Header from "../../../Shared/Admin/Header";

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
                    .put(this.route('admin.polls.update', this.poll.id).url(), this.form)
                    .then(() => this.sending = false)
            },
            destroy() {

            }
        }
    }
</script>
