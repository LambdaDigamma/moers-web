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

        <div class="mt-6 overflow-hidden rounded-lg shadow">
            <div class="relative w-full h-64 overflow-hidden rounded-t-lg" v-if="organisation.header_path">
                <img class="absolute object-cover object-center w-full h-full"
                     :src="organisation.header_path" />
            </div>
            <div class="px-4 py-5 overflow-hidden bg-white sm:px-6">
                <div class="flex flex-wrap justify-between -mt-2 -ml-4 sm:flex-nowrap">
                    <div class="flex flex-col items-center justify-center flex-shrink-0 w-32 mt-2 ml-4">
                        <img class="object-scale-down object-center w-32 h-auto"
                             :src="organisation.logo_path"
                             alt="" />
                    </div>
                    <div class="mt-2 ml-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{ organisation.name }}
                        </h3>
                        <p class="text-sm leading-5 text-gray-500">
                            {{ organisation.description }}
                        </p>
                    </div>
                    <div class="flex flex-col justify-center flex-shrink-0 w-32 mt-2 ml-4">
                        <WhiteButton>Folgen</WhiteButton>
                        <WhiteButton class="mt-2">Beitreten</WhiteButton>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mt-6">

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

    import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
    import TextInput from "@/Shared/UI/TextInput.vue";
    import LoadingButton from "@/Shared/UI/LoadingButton.vue";
    import PollResult from "@/Shared/PollResult.vue";
    import Header from "@/Shared/Admin/Header.vue";
    import TrashedMessage from "@/Shared/TrashedMessage.vue";
    import CardContainer from "@/Shared/UI/CardContainer.vue";
    import EventCard from "@/Shared/Events/EventCard.vue";
    import TextareaInput from "@/Shared/UI/TextareaInput.vue";
    import LayoutEditOrganisation from "@/Layout/LayoutEditOrganisation.vue";

    export default {
        name: "Edit",
        metaInfo() {
            return {
                title: this.organisation.name
            }
        },
        layout: (h, page) => {
            return h(LayoutAdmin, [
                h(LayoutEditOrganisation, { props: { organisation: page.context.props.organisation, endPath: '' } }, [page]),
            ])
        },
        components: {
            EventCard,
            CardContainer,
            TrashedMessage,
            TextareaInput,
            TextInput,
            LoadingButton,
            Header
        },
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
