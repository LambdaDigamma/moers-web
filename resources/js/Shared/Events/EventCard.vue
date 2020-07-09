<template>

    <inertia-link class="block group" :href="href">
        <div class="relative h-64 pb-4/6">
            <img v-if="event.header_url"
                 class="absolute inset-0 object-cover w-full h-full rounded-lg shadow-md group-hover:filter-brightness-90 transition ease-in-out transition-filter duration-150"
                 :src="event.header_url"
                 :alt="event.name + 'Titelbild'">
            <div v-else
                 class="absolute inset-0 object-cover w-full h-full rounded-lg shadow-md group-hover:filter-brightness-90 bg-gray-200 transition transition-filter ease-in-out duration-150">

            </div>
        </div>
        <div class="relative px-4 -mt-16">
            <div class="px-4 py-4 bg-white rounded-lg shadow-lg group-hover:bg-gray-100 transition transition-filter ease-in-out duration-150">
                <div class="flex items-baseline">
                    <div class="text-xs font-semibold tracking-wide text-gray-600 uppercase">
                        {{ subtitle }}
                    </div>
                </div>
                <h4 class="mt-0 text-base font-semibold leading-6 text-gray-900 lg:text-lg">
                    {{ event.name }}
                </h4>
                <div class="mt-0">
                    <span class="text-xs font-medium text-gray-500 md:text-sm">
                        {{ prettifiedDate }}
                    </span>
                </div>
            </div>
        </div>
    </inertia-link>

</template>

<script>
    import moment from 'moment';

    export default {
        name: "EventCard",
        props: {
            event: Object,
            href: String
        },
        computed: {
            prettifiedDate() {

                if (this.event.start_date !== null && this.event.end_date !== null) {

                    const startDate = moment(this.event.start_date)
                    const endDate = moment(this.event.end_date)

                    if (startDate.year() === endDate.year() &&
                        startDate.month() === endDate.month() &&
                        startDate.days() === endDate.days()) {
                        return startDate.format('dd, DD.MM. HH:mm') + " - " + endDate.format('HH:mm')

                    } else {
                        return startDate.format('dd, DD.MM. HH:mm') + " - " + endDate.format('dd, DD.MM. HH:mm')

                    }

                } else if (this.event.start_date) {

                    const startDate = moment(this.event.start_date)

                    if (startDate.hours() === 0 &&
                        startDate.minutes() === 0 &&
                        startDate.seconds() === 0) {
                        return startDate.format('dd, DD.MM.')
                    } else {
                        return startDate.format('dd, DD.MM. HH:mm')
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