<template>

    <div>

        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold leading-tight text-gray-900">
                Neue Benachrichtigungen
            </h2>

            <div class="mt-6 mb-10">
                <div class="bg-white shadow overflow-hidden sm:rounded-md" v-if="unreadNotifications.length !== 0">
                    <ul>
                        <li class="border-t border-gray-200" v-for="notification in unreadNotifications">
                            <NotificationItem :notification="notification" />
                        </li>
                    </ul>
                </div>
                <div class="bg-white shadow overflow-hidden sm:rounded-md" v-else>
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
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
                <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
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
    import NotificationItem from "./NotificationItem";
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";

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