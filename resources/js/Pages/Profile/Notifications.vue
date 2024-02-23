<template>

    <div>

        <div class="mx-auto max-w-7xl">
            <h2 class="text-3xl font-bold leading-tight text-gray-900">
                Neue Benachrichtigungen
            </h2>

            <div class="mt-6 mb-10">
                <div class="overflow-hidden bg-white shadow sm:rounded-md" v-if="unreadNotifications.length !== 0">
                    <ul>
                        <li class="border-t border-gray-200" v-for="notification in unreadNotifications" :key="notification.id">
                            <NotificationItem :notification="notification" />
                        </li>
                    </ul>
                </div>
                <div class="overflow-hidden bg-white shadow sm:rounded-md" v-else>
                    <div class="block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                Du hast keine neuen Benachrichtigungen.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl font-bold leading-tight text-gray-900">
                Alte Benachrichtigungen
            </h2>

            <div class="mt-6 mb-10">
                <div class="my-6 overflow-hidden bg-white shadow sm:rounded-md">
                    <ul>
                        <li class="border-t border-gray-200" v-for="notification in readNotifications">
                            <NotificationItem :notification="notification" />
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import NotificationItem from "./NotificationItem.vue";
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";

    export default {
        name: "Notifications",
        components: {NotificationItem},
        layout: LayoutGeneral,
        props: {
            unreadNotifications: {
                type: Array
            },
            readNotifications: {
                type: Array
            }
        }
    }
</script>

<style scoped>

</style>