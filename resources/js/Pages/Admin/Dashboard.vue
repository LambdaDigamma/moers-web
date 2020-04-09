<template>

    <div>

        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>


<!--        <div class="flex flex-wrap w-full">-->
<!--            <div class="w-full sm:w-1/2 lg:w-1/3">-->
<!--                <inertia-link :href="route('landingPage')" class="block px-4 py-3 m-2 rounded-lg dark:bg-gray-700 hover:no-underline">-->
<!--                    <h1 class="mb-0 text-lg font-semibold leading-none dark:text-white">Einträge</h1>-->
<!--                    <div class="w-20 px-3 py-2 mt-3 font-semibold rounded-lg dark:bg-yellow-500 dark:text-black">-->
<!--                        {{ numberOfEntries }}-->
<!--                    </div>-->
<!--                </inertia-link>-->
<!--            </div>-->
<!--            <div class="w-full sm:w-1/2 lg:w-1/3">-->
<!--                <inertia-link :href="route('landingPage')" class="block px-4 py-3 m-2 rounded-lg dark:bg-gray-700 hover:no-underline">-->
<!--                    <h1 class="mb-0 text-lg font-semibold leading-none dark:text-white">Organisationen</h1>-->
<!--                    <div class="w-20 px-3 py-2 mt-3 font-semibold rounded-lg dark:bg-yellow-500 dark:text-black">-->
<!--                        {{ numberOfOrganisations }}-->
<!--                    </div>-->
<!--                </inertia-link>-->
<!--            </div>-->
<!--        </div>-->
    </div>

</template>

<script>
    import Navigation from "../../Shared/Navigation";
    import LayoutAdmin from "../../Shared/LayoutAdmin";
    export default {
        name: "Dashboard",
        components: {Navigation},
        layout: LayoutAdmin,
        props: {
            numberOfEntries: Number,
            numberOfOrganisations: Number
        }
    }
</script>

<style scoped>

</style>