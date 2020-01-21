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
                            v-model="form.country"
                            class="w-full lg:w-1/2"
                            label="Country"
                            :errors="$page.errors.country">
                        <option v-for="group in this.groups" :value="group.id" :key="group.id">
                            {{ group.organisation.name }} • {{ group.name }}
                        </option>
                    </SelectInput>
                </div>
                <div class="px-6 py-3 bg-gray-700 border-t border-grey-500 flex items-center rounded-b-lg  dark:border-gray-600">
                    <LoadingButton
                            class="px-3 py-2 rounded-lg font-bold text-base dark:bg-green-600 dark:text-white"
                            type="submit"
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

    export default {
        name: "Create",
        components: {
            Header,
            LoadingButton,
            SelectInput
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