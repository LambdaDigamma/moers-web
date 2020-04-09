<template>

    <div>

        <header>
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Übersicht
                </h2>
            </div>
        </header>




        <!--        <div class="mt-4">-->

<!--            <div class="overflow-hidden bg-white rounded-lg shadow">-->
<!--                <div class="px-4 py-5 bg-white sm:px-6">-->
<!--                    <h3 class="text-lg font-medium leading-6 text-gray-900">-->
<!--                        Offene Abstimmungen-->
<!--                    </h3>-->
<!--                </div>-->
<!--                <ul>-->
<!--                    <li class="border-t border-gray-200" v-for="poll in unansweredPolls">-->
<!--                        <PollItem :poll="poll" />-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <div class="px-4 py-3 text-right border-t border-gray-200 bg-gray-50 sm:px-6">-->
<!--                    <span class="inline-flex rounded-md shadow-sm">-->
<!--                        <inertia-link :href="route('polls.index')" class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">-->
<!--                            Alle ansehen-->
<!--                        </inertia-link>-->
<!--                    </span>-->
<!--                </div>-->
<!--            </div>-->

<!--        </div>-->

    </div>

</template>

<script>
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral";
    import Icon from "../Shared/Icon";
    import PollItem from "../Shared/Polls/PollItem";

    export default {
        name: "Dashboard",
        components: {PollItem, Icon},
        layout: LayoutGeneral,
        props: {
            // unansweredPolls: Array,
            // answeredPolls: Array
        },
        created() {
            this.$root.$emit('newTitle', 'Übersicht')
        }
    }
</script>

<style scoped>

</style>