<template>

    <div>

        <Header title="Seiten">
            <PrimaryButton>
                Seite erstellen
            </PrimaryButton>
        </Header>

        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Slug
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Ersteller
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Letzte Änderung
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-for="page in pages.data" class="border-b border-gray-200 last:border-0">
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                {{ page.title }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 font-mono">
                                {{ page.slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ page.creator.first_name }} {{ page.creator.last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ page.updated_at | moment("from", "now") }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <inertia-link :href="route('admin.pages.edit', page.id)" class="text-blue-600 hover:text-blue-900">
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
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import {mapValues, pickBy, throttle} from "lodash";
    import Header from "../../../Shared/UI/Header";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";

    export default {
        name: "Index",
        components: {PrimaryButton, Header},
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
            }
        },
        watch: {
            form: {
                handler: throttle(function () {
                    let query = pickBy(this.form)
                    this.$inertia.replace(this.route('admin.pages.index', Object.keys(query).length ? query : {remember: 'forget'}))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        },
        created() {
            this.$root.$emit('newTitle', 'Unbeantwortete Abstimmungen')
        }
    }
</script>

<style scoped>

</style>