<template>

    <div class="pb-24">
        <Header
                :href="route('admin.organisations.index')"
                previousTitle="Organisationen"
                class="mb-8">
            {{ organisation.name }}
        </Header>

        <TrashedMessage v-if="organisation.deleted_at" class="mb-6" @restore="restore">
            Die Organisation wurde gelöscht.
        </TrashedMessage>



        <div class="mt-6 shadow rounded-lg overflow-hidden">
            <div class="h-64 w-full relative overflow-hidden rounded-t-lg " v-if="organisation.header_path">
                <img class="absolute object-center object-cover w-full h-full"
                     :src="organisation.header_path" />
            </div>
            <div class="bg-white px-4 py-5 sm:px-6 overflow-hidden">
                <div class="-ml-4 -mt-2 flex justify-between flex-wrap sm:flex-no-wrap">
                    <div class="ml-4 mt-2 flex-shrink-0 w-32 flex flex-col items-center justify-center">
                        <img class="w-32 h-auto object-center object-scale-down"
                             :src="organisation.logo_path"
                             alt="" />
                    </div>
                    <div class="ml-4 mt-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ organisation.name }}
                        </h3>
                        <p class="text-sm leading-5 text-gray-500">
                            {{ organisation.description }}
                        </p>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0 w-32 flex flex-col justify-center">
                        <WhiteButton>Folgen</WhiteButton>
                        <WhiteButton class="mt-2">Beitreten</WhiteButton>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-3 gap-6">

            <EventCard
                    v-for="(event, i) in events"
                    :event="event"
                    :key="event.id"
                    :href="route('admin.organisations.events.edit', [organisation.id, event.id])"
                    class="col-span-1">

            </EventCard>

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
    import EventCard from "../../../Shared/Events/EventCard";

    export default {
        name: "Edit",
        components: {
            EventCard,
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
