<template>

    <a class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="flex items-center flex-1 min-w-0">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-12 h-12 bg-red-300 rounded-full">
                        <svg class="w-8 h-8 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0 px-4">
                    <div>
                        <div>
                            <h1 class="text-lg font-medium leading-6 text-gray-900 truncate">
                                {{ notification.data.title }}
                            </h1>
                            <div class="text-sm leading-5 text-gray-700">
                                erhalten am
                                <time :datetime="notification.created_at">{{ notification.created_at | moment("dddd, Do MMM [um] H:mm") }}</time>
                            </div>
                        </div>
                        <div class="flex items-center mt-1 text-sm leading-5 text-gray-500">
                            <p>
                                {{ notification.data.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div>-->
<!--                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">-->
<!--                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>-->
<!--                </svg>-->
<!--            </div>-->
        </div>
    </a>

</template>

<script>
    export default {
        name: "NotificationItem",
        props: {
            notification: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>