<template>
    <div>
        <Header title="Seiten">
            <PrimaryButton> Seite erstellen </PrimaryButton>
        </Header>

        <div class="flex flex-col">
            <div
                class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
            >
                <div
                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg"
                >
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                >
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                >
                                    Slug
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                >
                                    Ersteller
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                >
                                    Letzte Änderung
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50"
                                ></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr
                                v-for="page in pages.data"
                                class="border-b border-gray-200 last:border-0"
                            >
                                <td
                                    class="px-6 py-4 text-sm font-medium leading-5 text-gray-900 whitespace-nowrap"
                                >
                                    {{ page.title }}
                                </td>
                                <td
                                    class="px-6 py-4 font-mono text-sm leading-5 text-gray-500 whitespace-nowrap"
                                >
                                    {{ page.slug }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-nowrap"
                                >
                                    {{ page.creator.first_name }}
                                    {{ page.creator.last_name }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-nowrap"
                                >
                                    {{
                                        page.updated_at | moment("from", "now")
                                    }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-nowrap"
                                >
                                    <inertia-link
                                        :href="
                                            route('admin.pages.edit', page.id)
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        Bearbeiten
                                    </inertia-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--        <div>-->

        <!--            <inertia-link v-for="page in pages.data"-->
        <!--                          :key="page.id"-->
        <!--                          :href="route('admin.pages.edit', page.id)"-->
        <!--                          class="block p-3 px-4 mb-3 rounded-lg dark:bg-gray-700 dark:text-white">-->

        <!--                <h4 class="text-2xl font-bold">-->
        <!--                    {{ page.title }}-->
        <!--                </h4>-->
        <!--                <p class="mb-0">Slug: {{ page.slug }}</p>-->

        <!--            </inertia-link>-->

        <!--        </div>-->

        <div class="mt-6">
            <Pagination :links="pages.links" />
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import { mapValues, pickBy, throttle } from "lodash";
import Header from "@/Shared/UI/Header.vue";
import PrimaryButton from "@/Shared/UI/PrimaryButton.vue";

export default {
    name: "Index",
    components: { PrimaryButton, Header },
    layout: LayoutAdmin,
    props: {
        pages: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        "admin.pages.index",
                        Object.keys(query).length
                            ? query
                            : { remember: "forget" }
                    )
                );
            }, 150),
            deep: true,
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        },
    },
    created() {
        this.$root.$emit("newTitle", "Unbeantwortete Abstimmungen");
    },
};
</script>

<style scoped></style>
