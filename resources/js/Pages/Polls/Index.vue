<template>
    <div>
        <header>
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Unbeantwortete Abstimmungen
                </h2>
            </div>
        </header>

        <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
            <ul>
                <li
                    class="border-t border-gray-200"
                    v-for="poll in polls.data"
                    :key="poll.id"
                >
                    <PollItem :poll="poll" />
                </li>
            </ul>
        </div>

        <div class="mt-6">
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
        this.$root.$emit("newTitle", "Unbeantwortete Abstimmungen");
    },
};
</script>

<style scoped></style>
