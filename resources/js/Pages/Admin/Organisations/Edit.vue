<template>

    <div>
        <Header
                :href="route('admin.organisations.index')"
                previousTitle="Organisationen"
                class="mb-8">
            {{ organisation.name }}
        </Header>
        <div class="flex flex-wrap">
            <div class="lg:w-1/2">
                <form class="md:mr-2 bg-white dark:bg-gray-700 rounded shadow" @submit.prevent="submit">
                    <h1 class="pt-6 px-6 text-xl md:text-2xl font-semibold dark:text-white">Allgemeine Informationen</h1>
                    <div class="p-6 flex flex-wrap">
                        <TextInput v-model="form.name" :errors="$page.errors.name" label="Name" class="w-full" />
                        <TextareaInput v-model="form.description" :errors="$page.errors.description" class="mt-3 w-full" label="Beschreibung" />
                    </div>
                    <div class="flex flex-col items-stretch md:flex-row px-6 py-3 md:items-center bg-gray-700 border-t border-grey-500 rounded-b-lg dark:border-gray-600">
                        <button
                            v-if="!organisation.deleted_at"
                            class="px-3 py-2 md:mt-0 rounded-lg font-semibold dark:bg-red-600 dark:text-white"
                            tabindex="-1"
                            type="button"
                            @click="destroy">
                            Organisation löschen
                        </button>
                        <loading-button
                            :loading="sending"
                            class="md:ml-auto md:mt-0 px-3 py-2 rounded-lg font-semibold text-base dark:text-gray-800 dark:bg-yellow-500"
                            type="submit">
                            Speichern
                        </loading-button>
                    </div>
                </form>
            </div>
            <div class="lg:w-1/2">

<!--                <div class="md:ml-2 bg-white dark:bg-gray-700 rounded shadow">-->
<!--                    <h1 class="pt-6 px-6 text-xl md:text-2xl font-semibold dark:text-white">Veranstaltungen</h1>-->

<!--                    <div-->
<!--                        class="px-4"-->
<!--                        v-for="event in events" :key="event.id">-->
<!--                        <h2 class="dark:text-white">{{ event.name }}</h2>-->
<!--                    </div>-->

<!--                </div>-->
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
            TextareaInput,
            TextInput,
            LoadingButton,
            Header
        },
        layout: LayoutAdmin,
        props: {
            organisation: Object,
            events: Array
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    name: this.organisation.name,
                    description: this.organisation.description,
                },
            }
        },
        methods: {
            submit() {
                // this.$inertia
                //     .put(this.route('admin.polls.update', this.poll.id), this.form)
                //     .then(() => this.sending = false)
            },
            destroy() {

            }
        }
    }
</script>
