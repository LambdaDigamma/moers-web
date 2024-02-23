<template>
    <div>
        <Header title="Abstimmungen">
            <PrimaryButton :href="route('admin.polls.create')">
                Abstimmung erstellen
            </PrimaryButton>
        </Header>

        <div>
            <inertia-link
                v-for="(poll, index) in polls.data"
                :key="poll.id"
                :href="route('admin.polls.edit', poll.id)"
                class="block p-3 px-4 mb-3 transition duration-150 bg-white rounded-lg shadow md:p-5 hover:bg-gray-50"
            >
                <h3
                    class="text-sm font-semibold leading-relaxed tracking-normal text-gray-500 uppercase"
                    v-if="poll.group && poll.group.organisation"
                >
                    {{ poll.group.organisation.name }} • {{ poll.group.name }}
                </h3>
                <h3
                    class="text-xs font-semibold leading-relaxed tracking-normal uppercase"
                    v-else
                >
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
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import Pagination from "@/Shared/Pagination.vue";
import SearchFilter from "@/Shared/SearchFilter.vue";
import { mapValues, pickBy, throttle } from "lodash";
import Header from "@/Shared/UI/Header.vue";
import PrimaryButton from "@/Shared/UI/PrimaryButton.vue";

export default {
    name: "Index",
    components: { PrimaryButton, Header, Pagination, SearchFilter },
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
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form);
                this.$inertia.replace(
                    this.route(
                        "admin.polls.index",
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
};
</script>

<style scoped></style>
