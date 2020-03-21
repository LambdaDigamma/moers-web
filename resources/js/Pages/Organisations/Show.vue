<template>

    <div>

        <div class="mt-6">

            <div class="shadow rounded-lg overflow-hidden">
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

            <div class="mt-8">
                <h3 class="text-gray-900 text-3xl font-bold">Veranstaltungen</h3>
                <p class="text-gray-600">Sieh dir alle geplanten Veranstaltungen der Organisation an.</p>
            </div>

            <div class="mt-6 sm:overflow-x-auto sm:overflow-y-hidden">
                <div class="sm:inline-flex sm:pt-2 sm:pb-8">

                    <div v-for="(event, i) in organisation.events" :class="{'mt-10 sm:ml-4': i > 0 }" class="sm:mt-0 sm:w-88 sm:flex-shrink-0">
                        <EventCard :event="event" />
                    </div>
                </div>
            </div>

<!--            <div class="mt-4 bg-white overflow-hidden shadow rounded-lg">-->
<!--                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">-->
<!--                    <div class="-ml-4 -mt-4 flex items-center justify-between flex-wrap sm:flex-no-wrap">-->
<!--                        <div class="ml-4 mt-4">-->
<!--                            <h3 class="text-lg leading-6 font-medium text-gray-900">-->
<!--                                Veranstaltungen-->
<!--                            </h3>-->
<!--                            <p class="mt-1 text-sm leading-5 text-gray-500">-->
<!--                                Sieh dir alle geplanten Veranstaltungen der Organisation an.-->
<!--                            </p>-->
<!--                        </div>-->
<!--                        <div class="ml-4 mt-4 flex-shrink-0">-->
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
            organisation: Object
        },
    }
</script>

<style scoped>

</style>