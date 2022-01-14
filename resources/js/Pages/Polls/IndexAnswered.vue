<template>
    <div>
        <h1
            class="hidden mt-2 text-2xl font-semibold md:text-4xl dark:text-white md:block"
        >
            Beantwortete Abstimmungen
        </h1>

        <!--        <div class="flex flex-col items-center justify-between mt-3 mb-6 md:flex-row">-->
        <!--            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset">-->
        <!--                <label class="block text-grey-darkest">Gelöschte:</label>-->
        <!--                <select v-model="form.trashed" class="w-full mt-1 form-select">-->
        <!--                    <option :value="null"/>-->
        <!--                    <option value="with">inklusive gelöschten</option>-->
        <!--                    <option value="only">nur gelöschte</option>-->
        <!--                </select>-->
        <!--            </search-filter>-->
        <!--            <inertia-link :href="route('admin.polls.create')" class="px-3 py-2 text-lg font-semibold text-white bg-green-700 rounded-lg hover:no-underline">-->
        <!--                <span>Erstellen</span>-->
        <!--            </inertia-link>-->
        <!--        </div>-->

        <div class="mt-2 md:mt-3">
            <inertia-link
                v-for="poll in polls.data"
                :key="poll.id"
                :href="route('polls.show', poll.id)"
                class="block p-2 px-3 mb-3 rounded-lg cursor-pointer dark:bg-gray-700 dark:text-white dark-hover:bg-gray-800 hover:no-underline"
            >
                <PollItem :poll="poll" />
            </inertia-link>
        </div>

        <div class="p-0">
            <Pagination :links="polls.links" class="my-2 my-md-4"></Pagination>
        </div>
    </div>
</template>

<script>
import LayoutGeneral from "@/Shared/Layouts/LayoutGeneral.vue";
import Pagination from "@/Shared/Pagination.vue";
import SearchFilter from "@/Shared/SearchFilter.vue";
import PollItem from "@/Shared/Polls/PollItem.vue";
import { mapValues, pickBy, throttle } from "lodash";

export default {
    name: "Index",
    layout: LayoutGeneral,
    components: { PollItem, Pagination, SearchFilter },
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
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        "polls.index.answered",
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
        this.$root.$emit("newTitle", "Beantwortete Abstimmungen");
    },
};
</script>

<style scoped></style>
