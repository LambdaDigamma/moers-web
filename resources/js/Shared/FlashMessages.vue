<template>
    <div>


        <div v-if="$page.flash.success && show" class="mb-8 rounded-md bg-green-200 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm leading-5 font-medium text-green-800">
                        {{ $page.flash.success }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-300 focus:outline-none focus:bg-green-100 transition ease-in-out duration-150" @click="show = false">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="($page.flash.error || Object.keys($page.errors).length > 0) && show" class="p-4 mb-8 bg-red-100 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium leading-5 text-red-800">
                        <span v-if="Object.keys($page.errors).length === 1">Es gibt einen Fehler in der Eingabe.</span>
                        <span v-else>Es gibt {{ Object.keys($page.errors).length }} Fehler in der Eingabe.</span>
                    </h3>
                    <div class="mt-2 text-sm leading-5 text-red-700">
                        <ul class="pl-5 list-disc">
                            <li class="mb-1" v-for="error in $page.errors">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>




<!--        <div v-if="($page.flash.error || Object.keys($page.errors).length > 0) && show"-->
<!--             class="flex items-center justify-between max-w-lg mb-8 bg-red-600 rounded">-->
<!--            <div class="flex items-center">-->
<!--                <svg class="w-4 h-4 ml-4 mr-2 flex-no-shrink fill-white" xmlns="http://www.w3.org/2000/svg"-->
<!--                     viewBox="0 0 20 20">-->
<!--                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"/>-->
<!--                </svg>-->
<!--                <div v-if="$page.flash.error" class="py-4 text-sm font-medium text-white">{{ $page.flash.error }}</div>-->
<!--                <div v-else class="py-4 text-sm font-medium text-white">-->
<!--                    <span v-if="Object.keys($page.errors).length === 1">Es gibt einen Fehler in der Eingabe.</span>-->
<!--                    <span v-else>Es gibt {{ Object.keys($page.errors).length }} Fehler in der Eingabe.</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <button type="button" class="p-2 mr-2 group" @click="show = false">-->
<!--                <svg class="block w-2 h-2 fill-red-700 group-hover:fill-red-700" xmlns="http://www.w3.org/2000/svg"-->
<!--                     width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908">-->
<!--                    <path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"/>-->
<!--                </svg>-->
<!--            </button>-->
<!--        </div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true,
            }
        },
        watch: {
            '$page.flash': {
                handler() {
                    this.show = true
                },
                deep: true,
            },
        },
    }
</script>
