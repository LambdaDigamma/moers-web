<template>
    <div class="pb-32">
        <div v-if="todayEvents.length !== 0">
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 md:text-3xl">
                    Laufende Veranstaltungen
                </h3>
                <p class="text-gray-600">
                    Sieh dir alle geplanten Veranstaltungen an.
                </p>
            </div>

            <div
                class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden"
            >
                <div
                    class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2"
                >
                    <div
                        v-for="(event, i) in todayEvents"
                        :key="event.id"
                        :class="{ 'ml-4 sm:ml-0': i > 0 }"
                        class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full"
                    >
                        <EventCard
                            :event="event"
                            :href="route('events.show', event.id)"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div v-if="todayUpcoming.length !== 0">
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 md:text-3xl">
                    Weitere heutige Veranstaltungen
                </h3>
                <p class="text-gray-600">
                    Sieh dir alle weiteren heutigen Veranstaltungen an.
                </p>
            </div>

            <div
                class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden"
            >
                <div
                    class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2"
                >
                    <div
                        v-for="(event, i) in todayUpcoming"
                        :key="event.id"
                        :class="{ 'ml-4 sm:ml-0': i > 0 }"
                        class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full"
                    >
                        <EventCard
                            :event="event"
                            :href="route('events.show', event.id)"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div v-if="nextUpcoming.length !== 0">
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 md:text-3xl">
                    In den nächsten Tagen
                </h3>
                <p class="text-gray-600">
                    Sieh dir alle nächsten Veranstaltungen an.
                </p>
            </div>

            <div
                class="mt-6 overflow-x-auto overflow-y-hidden sm:overflow-x-hidden"
            >
                <div
                    class="inline-flex pt-2 pb-8 sm:pt-0 sm:pb-6 sm:grid md:grid-cols-3 sm:gap-6 sm:grid-cols-2"
                >
                    <div
                        v-for="(event, i) in nextUpcoming"
                        :key="event.id"
                        :class="{ 'ml-4 sm:ml-0': i > 0 }"
                        class="flex-shrink-0 w-64 mt-0 sm:col-span-1 sm:w-full"
                    >
                        <EventCard
                            :event="event"
                            :href="route('events.show', event.id)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";

export default {
    name: "Index",
    layout: LayoutGeneral,
    props: {
        todayEvents: Array,
        todayUpcoming: Array,
        nextUpcoming: Array,
    },
};
</script>

<style scoped></style>
