<template>

    <div class="mt-6">

        <div class="flex flex-row">

            <div class="w-0 flex-1">

                <div class="bg-white shadow rounded-lg">
                    <div id="image-container">
                        <img class="w-full rounded-t-lg"
                             :src="event.header_url" alt="">
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-baseline">
                            <div class="text-xs text-gray-600 font-semibold uppercase tracking-wide">
                            </div>
                        </div>
                        <h1 class="mt-0 text-gray-900 font-semibold text-base lg:text-xl leading-6">{{ event.name }}</h1>
                        <div class="mt-0">
                            <span class="text-xs md:text-sm text-gray-500 font-medium">{{ prettifiedDate }}</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="px-4 py-5 sm:p-6">
                            <div v-for="block in event.page.blocks">

                                <MarkdownPresentation v-if="block.type === 'markdown'" :block="block" />

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex-shrink-0 w-80 ml-8">
                <div class="flex flex-col justify-end" v-if="event.organisation">
                    <div class="bg-white shadow rounded-lg">
                        <div class="relative h-40" v-if="event.organisation && event.organisation.header_url">
                            <img class="absolute rounded-t-lg inset-0 h-full w-full object-cover"
                                 :src="event.organisation.header_url" alt="">
                        </div>

                        <div class="px-4 py-5 sm:p-6 flex flex-col">
                            <div class="relative">
                                <span class="text-sm leading-5 font-medium text-gray-500 truncate">Veranstalter</span>
                                <h1 class="text-xl font-semibold">
                                    {{ event.organisation.name }}
                                </h1>
                                <p class="truncate-2-lines text-sm text-gray-700">
                                    {{ event.organisation.description }}
                                </p>
                                <PrimaryButton class="mt-3" block>
                                    Anzeigen
                                </PrimaryButton>
                                <div class="absolute z-40 right-0 top-0 -mt-10">
                                    <div class="bg-gray-700 rounded-md p-3 shadow-lg">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 flex flex-col justify-end" v-if="event.entry">
                    <div class="bg-white shadow rounded-lg">

                        <div class="relative h-40" v-if="event.entry && event.entry.header_url">
                            <img class="absolute rounded-t-lg inset-0 h-full w-full object-cover"
                                 :src="event.entry.header_url" alt="">
                        </div>

                        <div class="px-4 py-5 sm:p-6 flex flex-col">
                            <div class="relative">
                                <span class="text-sm leading-5 font-medium text-gray-500 truncate">Veranstaltungsort</span>
                                <h1 class="mt-0 text-xl font-semibold">
                                    {{ event.entry.name }}
                                </h1>
                                <span class="text-sm leading-5 text-gray-700">
                                    {{ event.entry.street }} {{ event.entry.house_number }}<br />
                                    {{ event.entry.postcode }} {{ event.entry.place }}
                                </span>
                                <PrimaryButton class="mt-3" block>
                                    Anzeigen
                                </PrimaryButton>
                                <div class="absolute z-40 right-0 top-0 -mt-10">
                                    <div class="bg-gray-700 rounded-md p-3 shadow-lg">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-white">
                                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>




<!--        <div class="mx-auto max-w-2xl">-->
<!--            -->
<!--        </div>-->
<!--        <div v-if="event.page && event.page.blocks" class="mt-6 max-w-4xl mx-auto bg-white overflow-hidden shadow rounded-lg">-->
<!--            <div class="px-4 py-5 sm:p-6">-->
<!--                <div v-for="block in event.page.blocks">-->

<!--                    <MarkdownPresentation v-if="block.type === 'markdown'" :block="block" />-->

<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

    </div>

</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import EventCard from "../../Shared/Events/EventCard";
    import moment from "moment";
    import PrimaryButton from "../../Shared/UI/PrimaryButton";

    export default {
        name: "Show",
        components: {PrimaryButton, EventCard},
        layout: LayoutGeneral,
        props: {
            event: Object
        },
        computed: {
            prettifiedDate() {

                if (this.event.start_date !== null && this.event.end_date !== null) {

                    const startDate = moment(this.event.start_date)
                    const endDate = moment(this.event.end_date)

                    if (startDate.year() === endDate.year() &&
                        startDate.month() === endDate.month() &&
                        startDate.days() === endDate.days()) {
                        return startDate.format('dddd, DD.MM. HH:mm') + " - " + endDate.format('HH:mm')

                    } else {
                        return startDate.format('dddd, DD.MM. HH:mm') + " - " + endDate.format('dddd, DD.MM. HH:mm')

                    }

                } else if (this.event.start_date) {

                    const startDate = moment(this.event.start_date)

                    if (startDate.hours() === 0 &&
                        startDate.minutes() === 0 &&
                        startDate.seconds() === 0) {
                        return startDate.format('dddd, DD.MM.')
                    } else {
                        return startDate.format('dddd, DD.MM. HH:mm')
                    }

                } else {
                    return "Datum noch nicht bekannt"
                }

            },
            subtitle() {

                if (this.event.organisation && this.event.entry) {
                    return this.event.organisation.name + " • " + this.event.entry.name
                } else if (this.event.organisation) {
                    return this.event.organisation.name
                }

            }
        }
    }
</script>

<style scoped>

</style>