<template>

    <div>

        <div class="mt-8">
            <h3 class="text-gray-900 text-3xl font-bold">Laufende Veranstaltungen</h3>
            <p class="text-gray-600">Sieh dir alle geplanten Veranstaltungen an.</p>
        </div>

        <div class="mt-6 sm:overflow-x-auto sm:overflow-y-hidden">
            <div class="sm:inline-flex sm:pt-2 sm:pb-8">

                <div v-for="(event, i) in todayEvents" :class="{'mt-10 sm:ml-4': i > 0 }" class="sm:mt-0 sm:w-88 sm:flex-shrink-0">
                    <EventCard :event="event" />
                </div>
            </div>
        </div>

    </div>


</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";

    export default {
        name: "Index",
        layout: LayoutGeneral,
        props: {
            todayEvents: Array
        }
    }
</script>

<style scoped>

</style>