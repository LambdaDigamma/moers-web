<template>

    <inertia-link :href="route('help.request.show', request.id)" class="block overflow-hidden transition duration-150 ease-in-out bg-white rounded-lg shadow hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex flex-row flex-wrap items-center">
                <h1 class="text-xl font-medium text-gray-600">
                    <span v-if="$page.props.auth.user !== null && $page.props.auth.user.id === request.creator_id && request.served_on === null">
                        Du benötigst noch Hilfe
                    </span>
                    <span v-else-if="$page.props.auth.user !== null && $page.props.auth.user.id === request.creator_id">
                        Du bekommst Hilfe eines Moersers
                    </span>
                    <span v-else-if="$page.props.auth.user !== null && request.helper && $page.props.auth.user.id === request.helper.id">
                        Du hilfst hier
                    </span>
                    <span v-else>
                        Jemand in <span class="font-semibold text-gray-900">{{ request.quarter.name }} ({{ request.quarter.postcode }})</span> benötigt Hilfe
                    </span>
                </h1>
                <span class="ml-2 -mb-1 inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium leading-5 bg-red-500 text-white"
                    v-if="$page.props.auth.user !== null && request.conversation && request.conversation.pivot.is_unread">
                    Neue Nachricht
                </span>
            </div>
            <p class="max-w-4xl mt-2">
                {{ request.request }}
            </p>
            <span class="inline-flex rounded-md shadow-sm" v-if="(request.served_on === null) && ($page.props.auth.user !== null && $page.props.auth.user.id !== request.creator_id)">
                <inertia-link :href="route('help.request.show', request.id)" class="inline-flex items-center px-3 py-2 mt-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring-blue active:bg-blue-700">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                    </svg>
                    Ich möchte helfen!
                </inertia-link>
            </span>
        </div>
    </inertia-link>

</template>

<script>
    export default {
        name: "HelpItem",
        props: {
            request: {
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>