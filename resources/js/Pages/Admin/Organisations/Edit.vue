<template>

    <div>
        <Header
                :href="route('admin.organisations.index')"
                previousTitle="Organisationen"
                class="mb-8">
            {{ organisation.name }}
        </Header>

        <TrashedMessage v-if="organisation.deleted_at" class="mb-6" @restore="restore">
            Die Organisation wurde gelöscht.
        </TrashedMessage>



        <div class="mt-6">

            <h1>Moers </h1>

            <div class="h-64 w-full relative overflow-hidden rounded-lg shadow-md">
                <img class="absolute object-center object-cover w-full h-full"
                     :src="organisation.header_path" />
            </div>




        </div>


        <div class="flex flex-wrap">
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
                    </template>

                </CardContainer>
            </div>
            <div class="lg:w-1/2">
                <CardContainer class="md:ml-2" :inset-container="false">
                    <template v-slot:header>
                        <div class="flex flex-row justify-between items-center">
                            <h1 class="text-xl md:text-2xl font-semibold dark:text-white">
                                Nächste Veranstaltungen
                            </h1>
                            <inertia-link
                                    class="block px-3 py-2 bg-green-700 rounded-lg text-white font-semibold text-lg hover:no-underline"
                                    :href="route('admin.organisations.events.create', organisation.id)">
                                Erstellen
                            </inertia-link>
                        </div>
                    </template>
                    <div>
                        <div class="py-2 px-4 border-t border-b dark:border-gray-600"
                             v-for="event in events" :key="event.id">
                            <h2 class="mb-0 font-semibold text-lg dark:text-white">
                                {{ event.name }}
                            </h2>
                        </div>
                    </div>
                </CardContainer>
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
    import TrashedMessage from "../../../Shared/TrashedMessage";
    import CardContainer from "../../../Shared/UI/CardContainer";

    export default {
        name: "Edit",
        components: {
            CardContainer,
            TrashedMessage,
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
                if (confirm('Möchtest Du diese Organisation löschen?')) {
                    this.$inertia.delete(this.route('admin.organisations.destroy', this.organisation.id))
                }
            },
            restore() {
                if (confirm('Möchtest Du diese Organisation wiederherstellen?')) {
                    this.$inertia.put(this.route('admin.organisations.restore', this.organisation.id))
                }
            }
        }
    }
</script>
