<template>

    <div>
        <span class="mb-1 text-xs font-semibold uppercase leading-normal tracking-normal dark:text-gray-600"
              v-if="poll.group && poll.group.organisation">
            {{ poll.group.organisation.name }} • {{ poll.group.name }}
        </span>
        <span class="text-xs font-semibold uppercase leading-relaxed tracking-normal dark:text-yellow-500" v-else>
            Unbekannte Gruppe
        </span>
        <h3 class="text-lg font-medium text-white m-0">
            {{ poll.question }} <span v-if="poll.is_closed" class="font-medium text-white">(beendet)</span>
        </h3>
        <div v-if="poll.results" class="mt-1 text-sm dark:text-white">
            <div v-if="poll.results.total === 1">
                {{ poll.results.total }} Benutzer hat abgestimmt.
            </div>
            <div v-else>
                {{ poll.results.total }} Benutzer haben abgestimmt.
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "PollItem",
        props: {
            poll: Object
        }
    }
</script>

<style scoped>

</style>