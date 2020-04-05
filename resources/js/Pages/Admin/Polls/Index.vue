<template>

    <div>
        <h1 class="text-4xl font-bold dark:text-white">Abstimmungen</h1>

        <div class="flex flex-col items-center justify-between mt-3 mb-6 md:flex-row">
            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">
                <label class="block text-grey-darkest">Gelöschte:</label>
                <select v-model="form.trashed" class="w-full mt-1 form-select">
                    <option :value="null"/>
                    <option value="with">inklusive gelöschten</option>
                    <option value="only">nur gelöschte</option>
                </select>
            </search-filter>
            <inertia-link :href="route('admin.polls.create')" class="px-3 py-2 text-lg font-semibold text-white bg-green-700 rounded-lg hover:no-underline">
                <span>Erstellen</span>
            </inertia-link>
        </div>

        <div>

            <inertia-link v-for="(poll, index) in polls.data"
                 :key="poll.id"
                 :href="route('admin.polls.edit', poll.id)"
                 class="block p-3 px-4 mb-3 rounded-lg dark:bg-gray-700 dark:text-white">

                <h3 class="text-xs font-semibold leading-relaxed tracking-normal uppercase dark:text-yellow-500"
                    v-if="poll.group && poll.group.organisation">
                    {{ poll.group.organisation.name }} • {{ poll.group.name }}
                </h3>
                <h3 class="text-xs font-semibold leading-relaxed tracking-normal uppercase dark:text-yellow-500" v-else>
                    Unbekannte Gruppe
                </h3>

                <h4 class="text-2xl font-bold">
                    {{ poll.question }}
                </h4>

                <div v-if="poll.results">
                    <div v-if="poll.results.total === 1">
                        {{ poll.results.total }} Benutzer hat abgestimmt.
                    </div>
                    <div v-else>
                        {{ poll.results.total }} Benutzer haben abgestimmt.
                    </div>
                </div>
            </inertia-link>

        </div>


        <div class="p-0">
            <Pagination :links="polls.links" class="my-2 my-md-4"></Pagination>
        </div>

    </div>

</template>

<script>
    import LayoutAdmin from "@/Shared/LayoutAdmin";
    import Pagination from "@/Shared/Pagination";
    import SearchFilter from "@/Shared/SearchFilter";
    import {mapValues, pickBy, throttle} from "lodash";

    export default {
        name: "Index",
        components: {Pagination, SearchFilter},
        layout: LayoutAdmin,
        props: {
            polls: Object,
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
                    this.$inertia.replace(this.route('admin.polls.index', Object.keys(query).length ? query : {remember: 'forget'}).url())
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = mapValues(this.form, () => null)
            },
        },
    }
</script>

<style scoped>

</style>