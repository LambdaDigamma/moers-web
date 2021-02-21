<template>

    <div>

        <div class="mt-6">

            <div class="overflow-hidden rounded-lg shadow">
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

            <div v-if="todayEvents.length !== 0">
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-gray-900 md:text-3xl">Laufende Veranstaltungen</h3>
                    <p class="text-gray-600">Sieh dir alle geplanten Veranstaltungen an.</p>
                </div>

                <div class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden">
                    <div class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2">

                        <div v-for="(event, i) in todayEvents" :class="{'ml-4 sm:ml-0': i > 0 }" class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full">
                            <EventCard :event="event" :href="route('events.show', event.id)" />
                        </div>
                    </div>
                </div>
            </div>


            <div v-if="todayUpcoming.length !== 0">
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-gray-900 md:text-3xl">Weitere heutige Veranstaltungen</h3>
                    <p class="text-gray-600">Sieh dir alle weiteren heutigen Veranstaltungen an.</p>
                </div>

                <div class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden">
                    <div class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2">

                        <div v-for="(event, i) in todayUpcoming" :class="{'ml-4 sm:ml-0': i > 0 }" class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full">
                            <EventCard :event="event" :href="route('events.show', event.id)" />
                        </div>
                    </div>
                </div>
            </div>


            <div v-if="nextUpcoming.length !== 0">
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-gray-900 md:text-3xl">In den nächsten Tagen</h3>
                    <p class="text-gray-600">Sieh dir alle nächsten Veranstaltungen an.</p>
                </div>

                <div class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden">
                    <div class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2">

                        <div v-for="(event, i) in nextUpcoming" :class="{'ml-4 sm:ml-0': i > 0 }" class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full">
                            <EventCard :event="event" :href="route('events.show', event.id)" />
                        </div>
                    </div>
                </div>
            </div>

<!--            <div class="mt-4 overflow-hidden bg-white rounded-lg shadow">-->
<!--                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">-->
<!--                    <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">-->
<!--                        <div class="mt-4 ml-4">-->
<!--                            <h3 class="text-lg font-medium leading-6 text-gray-900">-->
<!--                                Veranstaltungen-->
<!--                            </h3>-->
<!--                            <p class="mt-1 text-sm leading-5 text-gray-500">-->
<!--                                Sieh dir alle geplanten Veranstaltungen der Organisation an.-->
<!--                            </p>-->
<!--                        </div>-->
<!--                        <div class="flex-shrink-0 mt-4 ml-4">-->
<!--                            <PrimaryButton>-->
<!--                                Erstellen-->
<!--                            </PrimaryButton>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <ul>-->
<!--                    <li v-for="event in organisation.events" :key="event.id">-->
<!--                        <EventItem :event="event" />-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->

        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import WhiteButton from "../../Shared/UI/WhiteButton";
    import SecondaryButton from "../../Shared/UI/SecondaryButton";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";
    import EventItem from "../../Shared/Events/EventItem";
    import EventCard from "../../Shared/Events/EventCard";

    export default {
        name: "Show",
        components: {EventCard, EventItem, PrimaryButton, SecondaryButton, WhiteButton},
        layout: LayoutGeneral,
        props: {
            organisation: Object,
            todayEvents: Array,
            todayUpcoming: Array,
            nextUpcoming: Array
        },
    }
</script>

<style scoped>

</style>