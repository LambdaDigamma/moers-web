<template>

    <div>
        <Header title="Veranstaltungen">
            <PrimaryButton :href="route('admin.events.create')">
                Veranstaltung erstellen
            </PrimaryButton>
        </Header>

        <div class="grid grid-cols-3 gap-6 mt-6">

            <EventCard
              v-for="(event, i) in events.data"
              :event="event"
              :key="event.id"
              :href="route('admin.events.edit', [event.id])"
              class="col-span-1">

            </EventCard>

        </div>
        <Pagination class="mt-6" :links="events.links">

        </Pagination>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Pagination from "../../../Shared/Pagination";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";

    export default {
        name: "Index",
        components: {PrimaryButton, Pagination},
        layout: LayoutAdmin,
        props: {
            events: Object
        }
    }
</script>

<style scoped>

</style>