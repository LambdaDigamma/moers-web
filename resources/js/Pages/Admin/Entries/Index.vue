<template>
    <div>
        <Header title="Einträge"> </Header>

        <div>
            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <li
                    class="col-span-1 bg-white rounded-lg shadow"
                    v-for="entry in entries.data"
                    :key="entry"
                >
                    <div
                        class="flex items-center justify-between w-full p-6 space-x-6"
                    >
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3
                                    class="text-base font-medium leading-5 text-gray-900 truncate"
                                >
                                    {{ entry.name }}
                                </h3>
                            </div>
                            <p
                                class="mt-1 text-sm leading-5 text-gray-500 truncate"
                            >
                                {{ entry.street }} {{ entry.house_number }}
                            </p>
                            <div class="flex flex-wrap">
                                <span
                                    v-for="tag in entry.tags"
                                    :key="tag"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="flex -mt-px">
                            <div
                                class="flex flex-1 w-0 border-r border-gray-200"
                            >
                                <inertia-link
                                    :href="route('entries.index', [entry.id])"
                                    class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-transparent rounded-bl-lg hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-400"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span class="ml-3"> Auf Karte zeigen </span>
                                </inertia-link>
                            </div>
                            <div class="flex flex-1 w-0 -ml-px">
                                <inertia-link
                                    :href="
                                        route('admin.entries.edit', [entry.id])
                                    "
                                    class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 focus:z-10"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-400"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        ></path>
                                    </svg>
                                    <span class="ml-3"> Bearbeiten </span>
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <Pagination class="mt-6" :links="entries.links"></Pagination>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import Header from "@/Shared/UI/Header.vue";
import Pagination from "@/Shared/Pagination.vue";
import SecondaryButton from "@/Shared/UI/SecondaryButton.vue";

export default {
    name: "Index",
    components: { SecondaryButton, Pagination, Header },
    layout: LayoutAdmin,
    props: {
        entries: Object,
    },
};
</script>

<style scoped></style>
