<template>

    <div>
        <Header title="Veranstaltungen">

        </Header>

        <div class="grid grid-cols-3 gap-6 mt-6">

            <EventCard
              v-for="(event, i) in events.data"
              :event="event"
              :key="event.id"
              :href="route('admin.events.edit', [event.id])"
              class="col-span-1">
                <!--              :href="route('admin.organisations.events.edit', [organisation.id, event.id])"-->

            </EventCard>

        </div>
        <Pagination class="mt-6" :links="events.links">

        </Pagination>
    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import Pagination from "../../../Shared/Pagination";

    export default {
        name: "Index",
        components: {Pagination},
        layout: LayoutAdmin,
        props: {
            events: Object
        }
    }
</script>

<style scoped>

</style>