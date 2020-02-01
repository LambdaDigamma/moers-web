<template>

    <div class="pb-12">
        <div class="lg:w-1/2">
            <CardContainer class="md:mr-2" show-action-bar>
                <template v-slot:header>
                    <h1 class="text-xl md:text-2xl font-semibold dark:text-white">
                        Allgemeine Informationen
                    </h1>
                </template>
                <div>
                    <form @submit.prevent="submit">
                        <div class="flex flex-wrap">
                            <TextInput v-model="form.name" :errors="$page.errors.name" label="Name" class="w-full" />
                            <TextareaInput v-model="form.description" :errors="$page.errors.description" class="mt-3 w-full" label="Beschreibung" />
                        </div>
                    </form>
                </div>
                <template v-slot:actions>
                    <div class="flex flex-col items-stretch md:flex-row md:items-center bg-gray-700">
                        <LoadingButton
                                :loading="sending"
                                class="md:ml-auto md:mt-0 px-3 py-2 rounded-lg font-semibold text-base dark:text-gray-800 dark:bg-yellow-500"
                                type="submit">
                            Speichern
                        </LoadingButton>
                    </div>
                </template>
            </CardContainer>
        </div>

        <div class="mt-4 w-full">
            <PageEditor>

            </PageEditor>
        </div>

    </div>

</template>

<script>
    import CardContainer from "../../../Shared/UI/CardContainer";
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import LoadingButton from "../../../Shared/LoadingButton";
    import TextInput from "../../../Shared/TextInput";
    import TextareaInput from "../../../Shared/TextareaInput";
    import PageEditor from "../../../Shared/PageEditor";

    export default {
        name: "CreateEvent",
        components: {PageEditor, TextareaInput, TextInput, LoadingButton, CardContainer},
        layout: LayoutAdmin,
        props: {

        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    name: null,
                    description: null
                },
            }
        },
        methods: {
            submit() {
                // this.$inertia
                //     .put(this.route('admin.polls.update', this.poll.id), this.form)
                //     .then(() => this.sending = false)
            },
        }
    }
</script>

<style scoped>

</style>