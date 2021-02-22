<template>
				<div class="min-h-screen bg-gray-100 pb-24">
								<div class="relative h-80">
												<Navigation class="absolute top-0 right-0 left-0 z-10"></Navigation>
												<div class="absolute top-0 right-0 bottom-0 left-0 bg-gray-800" aria-hidden="true">
																<img class="object-cover object-right-bottom w-full h-full" src="/images/moers.jpg" style="filter: brightness(50%); -webkit-filter: brightness(50%);">
												</div>
								</div>
								<div class="relative px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
												<div class="overflow-hidden -mt-12 bg-white rounded-lg shadow-lg">
																<div class="py-5 px-4 sm:p-6">
																				<div class="h-32"></div>
																</div>
												</div>
								</div>

								<div class="px-4 mx-auto mt-12 max-w-5xl sm:px-6 lg:px-8 space-y-2">
												<div class="flex flex-row items-baseline justify-between">
																<h2 class="text-lg font-bold text-gray-800">Veranstaltungen</h2>
																<inertia-link class="font-semibold text-sm text-red-500">Mehr</inertia-link>
												</div>
								</div>

								<div
												class="flex pb-6 mt-4 overflow-x-scroll no-scrollbar"
								>
												<div
																class="flex px-4 space-x-4 flex-nowrap"
												>

																<div class="relative inline-block w-64 max-w-xs" v-for="i in 10">
																				<div
																								class="overflow-hidden transition-shadow duration-300 ease-in-out bg-gray-300 rounded shadow-md aspect-w-6 aspect-h-4 hover:shadow-xl"
																				>

																				</div>
																				<div class="relative mx-2 -mt-10 transition duration-150 ease-in-out bg-white shadow-lg group-hover:bg-gray-100 transition-filter rounded-lg">
																								<div class="px-4 py-4">
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
</template>

<script>

import Navigation from "@/UI/Navigation";
export default {
				name: "Home",
				components: {Navigation},
}
</script>

<style scoped>

</style>
