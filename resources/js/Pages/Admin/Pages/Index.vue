<template>

    <div>

        <h1 class="text-4xl font-bold dark:text-white">Seiten</h1>

        <div class="flex flex-col items-center justify-between mt-3 mb-6 md:flex-row">
            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">
                <label class="block text-grey-darkest">Gelöschte:</label>
                <select v-model="form.trashed" class="w-full mt-1 form-select">
                    <option :value="null"/>
                    <option value="with">inklusive gelöschten</option>
                    <option value="only">nur gelöschte</option>
                </select>
            </search-filter>
            <!--        <inertia-link :href="route('admin.pages.create')" class="px-3 py-2 text-lg font-semibold text-white bg-green-700 rounded-lg hover:no-underline">-->
            <!--            <span>Erstellen</span>-->
            <!--        </inertia-link>-->
        </div>

        <div>

            <inertia-link v-for="page in pages.data"
                          :key="page.id"
                          :href="route('admin.pages.edit', page.id)"
                          class="block p-3 px-4 mb-3 rounded-lg dark:bg-gray-700 dark:text-white">

                <h4 class="text-2xl font-bold">
                    {{ page.title }}
                </h4>
                <p class="mb-0">Slug: {{ page.slug }}</p>

            </inertia-link>

        </div>


        <div class="p-0">
            <Pagination :links="pages.links" class="my-2 my-md-4" />
        </div>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import {mapValues, pickBy, throttle} from "lodash";

    export default {
        name: "Index",
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