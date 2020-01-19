<template>

    <div>
        <div class="w-full flex flex-wrap">
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <inertia-link :href="route('landingPage')" class="m-2 px-4 py-3 block rounded-lg dark:bg-gray-700 hover:no-underline">
                    <h1 class="mb-0 text-lg font-semibold leading-none dark:text-white">Benutzer</h1>
                    <div class="mt-3 font-bold rounded-lg w-20 px-3 py-2 dark:bg-yellow-500 dark:text-black">
                        120
                    </div>
                </inertia-link>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <inertia-link :href="route('landingPage')" class="m-2 px-4 py-3 block rounded-lg dark:bg-gray-700 hover:no-underline">
                    <h1 class="mb-0 text-lg font-semibold leading-none dark:text-white">Organisationen</h1>
                    <div class="mt-3 font-bold rounded-lg w-20 px-3 py-2 dark:bg-yellow-500 dark:text-black">
                        120
                    </div>
                </inertia-link>
            </div>
        </div>
    </div>

</template>

<script>
    import Navigation from "../../Shared/Navigation";
    import LayoutAdmin from "../../Shared/LayoutAdmin";
    export default {
        name: "Dashboard",
        components: {Navigation},
        layout: LayoutAdmin
    }
</script>

<style scoped>

</style>