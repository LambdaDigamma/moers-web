<template>

    <inertia-link :href="route('help.request.show', request.id)" class="block bg-white overflow-hidden shadow rounded-lg hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-xl text-gray-600 font-medium" v-if="$page.auth.user !== null && $page.auth.user.id !== request.creator_id">Jemand in <span class="font-semibold text-gray-900">{{ request.quarter.name }} ({{ request.quarter.postcode }})</span> benötigt Hilfe</h1>
            <h1 class="text-xl text-gray-600 font-medium" v-else>Du benötigst Hilfe</h1>
            <p class="mt-2">
                {{ request.request }}
            </p>
            <span class="inline-flex rounded-md shadow-sm" v-if="$page.auth.user !== null && $page.auth.user.id !== request.creator_id">
                <inertia-link :href="route('help.request.show', request.id)" class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                    </svg>
                    Ich helfe!
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