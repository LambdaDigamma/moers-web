<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl dark:text-white">
            <inertia-link class="dark:text-yellow-500 dark-hover:text-yellow-600 hover:no-underline" :href="route('admin.polls.index')">Abstimmungen</inertia-link>
            <span class="text-yellow-500 font-medium">/</span>
            Erstellen
        </h1>
        <div class="rounded shadow bg-white dark:bg-gray-700 max-w-4xl">
            <form @submit.prevent="submit">
                <div class="p-6 flex flex-wrap">
                    <TextInput v-model="form.question" :errors="$page.errors.question" label="Frage" class="w-full"></TextInput>
                    <TextareaInput v-model="form.description" :errors="$page.errors.description" class="mt-3 w-full" label="Beschreibung" />
                    <select-input v-model="form.country" :errors="$page.errors.country" class="w-full lg:w-1/2" label="Country">
                        <option v-for="group in this.groups" :value="group.id" :key="group.id">{{ group.organisation.name }} • {{ group.name }}</option>
                    </select-input>
                </div>
                <div class="px-6 py-3 bg-gray-700 border-t border-grey-500 flex items-center rounded-b-lg  dark:border-gray-600">
                    <loading-button :loading="sending" class="px-3 py-2 rounded-lg font-bold text-base dark:bg-green-600 dark:text-white" type="submit">Abstimmung erstellen</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import LayoutAdmin from "@/Shared/LayoutAdmin";
    import LoadingButton from "@/Shared/LoadingButton";

    export default {
        name: "Create",
        components: {
            LoadingButton
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
                },
            }
        },
        methods: {
            submit() {

            }
        }
    }
</script>

<style scoped>

</style>