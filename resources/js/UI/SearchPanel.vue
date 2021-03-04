<template>
    <div class="overflow-hidden bg-white rounded-lg shadow-lg">
        <div class="flex-1 flex h-16 px-4 border-b border-gray-200">
            <form action="#" class="w-full flex md:ml-0" method="GET">
                <label class="sr-only" for="search_field">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/search -->
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" fill-rule="evenodd"/>
                        </svg>
                    </div>
                    <input
                        id="search_field"
                        class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                        name="search"
                        placeholder="Suche Orte, Geschäfte oder Veranstaltungen..."
                        type="search"
                    >
                </div>
            </form>
        </div>
        <div class="py-5 px-4 sm:p-6 space-y-6">
            <div>
                <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Orte</h2>
                <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">
                            GA
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Restaurants</a>
                                <p class="text-gray-500">über 100</p>
                            </div>
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-purple-600 text-white text-sm font-medium rounded-l-md">
                            CD
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Veranstaltungen</a>
                                <p class="text-gray-500">30 heute</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-yellow-500 text-white text-sm font-medium rounded-l-md">
                            T
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Templates</a>
                                <p class="text-gray-500">16 Members</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-green-500 text-white text-sm font-medium rounded-l-md">
                            RC
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Abfallkalender</a>
                                <p class="text-gray-500">8 Members</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>
                </ul>
            </div>

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div>
                <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Kategorien</h2>
                <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">
                            GA
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Geschäfte</a>
                                <p class="text-gray-500">über 100</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-purple-600 text-white text-sm font-medium rounded-l-md">
                            CD
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Veranstaltungen</a>
                                <p class="text-gray-500">30 heute</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-yellow-500 text-white text-sm font-medium rounded-l-md">
                            T
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Templates</a>
                                <p class="text-gray-500">16 Members</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>

                    <li class="col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-green-500 text-white text-sm font-medium rounded-l-md">
                            RC
                        </div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a class="text-gray-900 font-medium hover:text-gray-600" href="#">Abfallkalender</a>
                                <p class="text-gray-500">8 Members</p>
                            </div>
                            <!--																																								<div class="flex-shrink-0 pr-2">-->
                            <!--																																												<button class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
                            <!--																																																<span class="sr-only">Open options</span>-->
                            <!--																																																<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
                            <!--																																																				<path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />-->
                            <!--																																																</svg>-->
                            <!--																																												</button>-->
                            <!--																																								</div>-->
                        </div>
                    </li>
                </ul>
            </div>

            <!--																								<div class="h-32"></div>-->
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchPanel"
}
</script>

<style scoped>

</style>
