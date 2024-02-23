<template>
    <inertia-link href="#" class="block transition duration-150 ease-in-out border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="text-base font-medium tracking-normal truncate text-black-600">
                    {{ event.name }}
                </div>
                <div class="flex flex-shrink-0 ml-2">
                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                        Full-time
                    </span>
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="items-center sm:flex">
                    <span>
                        <time datetime="2020-01-07" class="text-sm text-gray-500">
                            {{ prettifiedDate }}
                        </time>
                    </span>
                </div>
                <div class="flex items-center mt-2 text-sm leading-5 text-gray-500 sm:mt-0">
                    <div class="flex items-center mr-6 text-sm leading-5 text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        Engineering
                    </div>
                    <div class="flex items-center mt-2 text-sm leading-5 text-gray-500 sm:mt-0">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Remote
                    </div>
                </div>
            </div>
        </div>
    </inertia-link>
</template>

<script>
    export default {
        name: "EventItem",
        props: {
            event: Object
        },
        computed: {
            prettifiedDate() {

                if (this.event.start_date) {
                    return this.event.start_date
                }

            }
        }
    }
</script>

<style scoped>

</style>