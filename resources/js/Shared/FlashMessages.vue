<template>
    <div>
        <div class="fixed inset-0 right-0 flex items-end justify-center px-4 py-6 mr-2 pointer-events-none z-100 sm:p-6 sm:items-start sm:justify-end">
            <transition
                enter-active-class="transition duration-300 ease-out transform"
                enter-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition duration-100 ease-in"
                leave-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="$page.props.flash.success && show" class="w-full max-w-sm bg-white rounded-lg shadow-lg pointer-events-auto">
                    <div class="overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium leading-5 text-gray-900">
                                        Das lief doch super!
                                    </p>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ $page.props.flash.success }}
                                    </p>
                                </div>
                                <div class="flex flex-shrink-0 ml-4">
                                    <button class="inline-flex text-gray-400 transition duration-150 ease-in-out focus:outline-none focus:text-gray-500" @click="show = false">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <transition
                enter-active-class="transition duration-300 ease-out transform"
                enter-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition duration-100 ease-in"
                leave-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="hasError && show" class="w-full max-w-sm bg-white rounded-lg shadow-lg pointer-events-auto">
                    <div class="overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium leading-5 text-gray-900">
                                        Da ist wohl etwas schiefgelaufen...
                                    </p>
                                    <p class="mt-2 text-sm leading-5 text-gray-500">
                                        <ul class="pl-4 list-disc">
                                            <li class="mb-1" v-for="error in $page.props.errors">
                                                {{ error[0] }}
                                            </li>
                                        </ul>
                                    </p>
                                </div>
                                <div class="flex flex-shrink-0 ml-4">
                                    <button class="inline-flex text-gray-400 transition duration-150 ease-in-out focus:outline-none focus:text-gray-500" @click="show = false">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FlashMessages",
        data() {
            return {
                show: true,
            }
        },
        computed: {
            hasError() {
                return (this.$page.props.flash.error || Object.keys(this.$page.props.errors).length > 0)
            }
        },
        watch: {
            '$page.props.flash': {
                handler() {
                    this.show = true
                    setTimeout(() => this.show = false, 5000)
                },
                deep: true,
            },
        },
    }
</script>
