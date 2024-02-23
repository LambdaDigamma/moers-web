<template>
    <inertia-link
        :href="route('polls.show', poll.id)"
        class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50"
    >
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="flex items-center flex-1 min-w-0">
                <div class="flex-1 min-w-0 md:grid md:grid-cols-2 md:gap-4">
                    <div>
                        <div class="text-sm font-medium leading-5 truncate">
                            {{ poll.question }}
                        </div>
                        <div
                            class="flex items-center mt-2 text-sm leading-5 text-gray-500"
                        >
                            <span
                                class="truncate"
                                v-if="poll.group && poll.group.organisation"
                            >
                                {{ poll.group.organisation.name }} •
                                {{ poll.group.name }}
                            </span>
                            <span class="truncate" v-else>
                                Unbekannte Gruppe
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div>
                            <div class="text-sm leading-5 text-gray-900">
                                <span v-if="poll.results === null"
                                    >Kein Benutzer hat abgestimmt.</span
                                >
                                <span v-else-if="poll.results.total === 1">
                                    {{ poll.results.total }} Benutzer hat
                                    abgestimmt.
                                </span>
                                <span v-else>
                                    {{ poll.results.total }} Benutzer haben
                                    abgestimmt.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <svg
                    class="w-5 h-5 text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </div>
    </inertia-link>
</template>

<script>
export default {
    name: "PollItem",
    props: {
        poll: Object,
    },
};
</script>

<style scoped></style>
