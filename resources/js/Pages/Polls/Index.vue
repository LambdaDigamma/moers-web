<template>

    <div>
        <h1 class="mt-2 font-semibold text-2xl md:text-4xl dark:text-white hidden md:block">Unbeantwortete Abstimmungen</h1>

<!--        <div class="mt-3 mb-6 flex flex-col md:flex-row justify-between items-center">-->
<!--            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">-->
<!--                <label class="block text-grey-darkest">Gelöschte:</label>-->
<!--                <select v-model="form.trashed" class="mt-1 w-full form-select">-->
<!--                    <option :value="null"/>-->
<!--                    <option value="with">inklusive gelöschten</option>-->
<!--                    <option value="only">nur gelöschte</option>-->
<!--                </select>-->
<!--            </search-filter>-->
<!--            <inertia-link :href="route('admin.polls.create')" class="px-3 py-2 bg-green-700 rounded-lg text-white font-semibold text-lg hover:no-underline">-->
<!--                <span>Erstellen</span>-->
<!--            </inertia-link>-->
<!--        </div>-->

        <div class="mt-2 md:mt-3">

            <inertia-link v-for="poll in polls.data"
                          :key="poll.id"
                          :href="route('polls.show', poll.id)"
                          class="block mb-3 p-2 px-3 rounded-lg dark:bg-gray-700 dark:text-white dark-hover:bg-gray-800 hover:no-underline cursor-pointer">
                <PollItem :poll="poll" />
            </inertia-link>

        </div>

        <div class="p-0">
            <Pagination :links="polls.links" class="my-2 my-md-4"></Pagination>
        </div>

    </div>

</template>

<script>
    import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral";
    import Pagination from "@/Shared/Pagination";
    import SearchFilter from "@/Shared/SearchFilter";
    import {mapValues, pickBy, throttle} from "lodash";
    import PollItem from "../../Shared/Polls/PollItem";

    export default {
        name: "Index",
        layout: LayoutGeneral,
        components: {PollItem, Pagination, SearchFilter},
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
        created() {
            this.$root.$emit('newTitle', 'Unbeantwortete Abstimmungen')
        }
    }
</script>

<style scoped>

</style>