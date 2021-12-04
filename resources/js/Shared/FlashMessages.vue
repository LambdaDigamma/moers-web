<template>
    <div>
        <transition
            appear
            enter-active-class="transition duration-100 ease-out"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="$page.props.flash.success && show"
                class="p-4 mb-8 bg-green-200 rounded-lg shadow"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="w-5 h-5 text-green-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium leading-5 text-green-800">
                            {{ $page.props.flash.success }}
                        </p>
                    </div>
                    <div class="pl-3 ml-auto">
                        <div class="-mx-1.5 -my-1.5">
                            <button
                                class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-300 focus:outline-none focus:bg-green-100 transition ease-in-out duration-150"
                                @click="show = false"
                            >
                                <svg
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="
                    ($page.props.flash.error ||
                        Object.keys($page.props.errors).length > 0) &&
                    show
                "
                class="p-4 mb-8 bg-red-100 rounded-lg shadow"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="w-5 h-5 text-red-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium leading-5 text-red-800">
                            <span v-if="Object.keys($page.props.errors).length === 1"
                                >Es gibt einen Fehler in der Eingabe.</span
                            >
                            <span v-else
                                >Es gibt
                                {{ Object.keys($page.props.errors).length }} Fehler in
                                der Eingabe.</span
                            >
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-red-700">
                            <ul class="pl-5 list-disc">
                                <li
                                    class="mb-1"
                                    v-for="(error, index) in $page.props.errors"
                                    :key="index"
                                >
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: true,
        };
    },
    watch: {
        "$page.props.flash": {
            handler() {
                this.show = true;
            },
            deep: true,
        },
    },
};
</script>
