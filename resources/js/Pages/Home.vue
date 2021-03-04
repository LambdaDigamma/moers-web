<template>
    <div class="min-h-screen bg-gray-200">
        <div class="pb-24 mx-auto max-w-6xl min-h-screen bg-gray-100 shadow-md">
            <div class="relative h-80 lg:h-96">
                <Navigation class="absolute top-0 right-0 left-0 z-10"></Navigation>
                <div class="absolute top-0 right-0 bottom-0 left-0 bg-gray-800" aria-hidden="true">
                    <img class="object-cover object-right-bottom w-full h-full" src="/images/moers.jpg" style="filter: brightness(30%); -webkit-filter: brightness(30%);">
                </div>
            </div>
            <div class="relative px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
                <!--																<SearchPanel class="-mt-24"></SearchPanel>-->
                <CategoryPanel class="-mt-24"></CategoryPanel>
            </div>

            <div class="px-4 mx-auto mt-12 lg:mt-32 space-y-2 max-w-6xl sm:px-6 lg:px-8">
                <div class="flex flex-row justify-between items-baseline">
                    <h2 class="text-lg font-bold text-gray-800 lg:text-2xl">Nächste Veranstaltungen</h2>
                    <inertia-link class="text-sm font-semibold text-red-500 lg:text-lg">Mehr</inertia-link>
                </div>
            </div>

            <div
                class="flex overflow-x-scroll pb-6 mt-4 no-scrollbar"
            >
                <div
                    class="flex flex-nowrap px-4 sm:px-6 lg:px-8 space-x-4"
                >

                    <div class="group inline-block relative w-64 max-w-xs lg:max-w-sm" v-for="i in 10">
                        <div
                            class="overflow-hidden bg-gray-300 rounded shadow-md transition-shadow duration-300 ease-in-out aspect-w-6 aspect-h-4 hover:shadow-xl"
                        >

                        </div>
                        <div class="relative mx-2 -mt-10 bg-white rounded-lg shadow-lg transition duration-150 ease-in-out group-hover:bg-gray-100">
                            <div class="py-4 px-4">
                                <div class="flex items-baseline">
                                    <div class="text-xs font-semibold tracking-wide text-true-gray-500 uppercase">
                                        ENNI Eventhalle
                                    </div>
                                </div>
                                <h4 class="mt-0 text-base font-semibold leading-6 text-gray-900 lg:text-lg">
                                    Ghost Dogs (DE)
                                </h4>
                                <div class="mt-0">
                                <span class="text-xs font-medium text-gray-700 md:text-sm leading-0">
                                    So, 9. Juni 2020 11:00
                                </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!--								<div class="overflow-hidden bg-white rounded-lg shadow">-->
            <!--												<div class="py-5 px-4 sm:p-6">-->
            <!--																<div class="h-32"></div>-->
            <!--												</div>-->
            <!--								</div>-->
        </div>
        <Footer></Footer>
    </div>
</template>

<script>

import Navigation from "@/UI/Navigation";
import Footer from "@/UI/Footer";
import SearchPanel from "@/UI/SearchPanel";
import CategoryPanel from "@/UI/CategoryPanel";
export default {
    name: "Home",
    components: {CategoryPanel, SearchPanel, Footer, Navigation},
}
</script>

<style scoped>

</style>
