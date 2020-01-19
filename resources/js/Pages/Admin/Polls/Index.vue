<template>

    <div>
        <h1 class="font-bold text-4xl dark:text-white">Abstimmungen</h1>

        <div class="mt-3 mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">
                <label class="block text-grey-darkest">Gelöschte:</label>
                <select v-model="form.trashed" class="mt-1 w-full form-select">
                    <option :value="null"/>
                    <option value="with">inklusive gelöschten</option>
                    <option value="only">nur gelöschte</option>
                </select>
            </search-filter>
            <inertia-link class="px-3 py-2 bg-green-700 rounded-lg text-white font-semibold text-lg">
                <span>Erstellen</span>
            </inertia-link>
        </div>

        <div>

            <div v-for="(poll, index) in polls.data"
                 :key="poll.id"
                 class="mb-3 p-3 px-4 rounded-lg dark:bg-gray-700 dark:text-white">

                <h3 class="text-xs font-semibold uppercase leading-relaxed tracking-normal dark:text-yellow-500"
                    v-if="poll.group && poll.group.organisation">
                    {{ poll.group.organisation.name }} • {{ poll.group.name }}
                </h3>
                <h3 class="text-xs font-semibold uppercase leading-relaxed tracking-normal dark:text-yellow-500" v-else>
                    Unbekannte Gruppe
                </h3>


                <h4 class="font-bold text-2xl">
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
                <!--                <b-button :to="{ name: 'polls.poll', params: { id: poll.id } }" variant="primary">Ergebnisse ansehen</b-button>-->
            </div>


        </div>


        <div class="p-0">
            <!--            <table class="table-auto dark:text-white">-->
            <!--                <thead>-->
            <!--                <tr class="text-left font-bold">-->
            <!--                    <th class="py-3 font-bold">Name</th>-->
            <!--                    <th class="py-3 font-bold"></th>-->
            <!--                </tr>-->
            <!--                </thead>-->
            <!--                <tbody>-->
            <!--                <tr class="" v-for="(poll, key) in polls.data" :key="key">-->
            <!--                    <td>-->
            <!--                        <div class="flex items-center dark:text-white">-->
            <!--                            <div class="">{{ poll.question }}</div>-->
            <!--                        </div>-->
            <!--                    </td>-->
            <!--                    <td class="d-flex justify-content-end align-items-center">-->
            <!--&lt;!&ndash;                        <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-muted" />&ndash;&gt;-->
            <!--                    </td>-->
            <!--                </tr>-->
            <!--                <tr v-if="polls.data.length === 0">-->
            <!--                    <td class="py-3">Keine Abstimmungen.</td>-->
            <!--                </tr>-->
            <!--                </tbody>-->
            <!--            </table>-->

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
                    this.$inertia.replace(this.route('admin.polls.index', Object.keys(query).length ? query : {remember: 'forget'}))
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