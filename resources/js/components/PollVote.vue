<template>
    <div>
        <div class="mt-0">
            <h1 class="text-2xl font-semibold dark:text-white">
                {{ poll.question }}
            </h1>
            <p class="text-base font-normal dark:text-white">
                {{ poll.description }}
            </p>
        </div>

        <form @submit.prevent="vote">
            <div class="mt-2">
                <div class="flex items-stretch w-full my-3">
                    <div
                        class="flex items-center pl-1 rounded-l dark:bg-gray-800"
                    >
                        <icon
                            name="search"
                            class="w-4 h-4 m-2 dark:fill-white"
                        ></icon>
                    </div>
                    <input
                        @keydown.enter.prevent=""
                        v-model="query"
                        placeholder="Suchen…"
                        type="text"
                        class="w-full px-2 py-2 rounded-r md:px-2 md:py-3 focus:ring dark:text-white dark:bg-gray-600"
                    />
                </div>

                <div class="">
                    <div
                        class="flex justify-between mt-1 border-4 border-transparent rounded dark:bg-gray-600"
                        v-for="option in filteredOptions"
                        :key="option.id"
                        @click="clickedOption(option.id)"
                        :class="{
                            'border-green-700': selectionIndex.includes(
                                option.id
                            ),
                        }"
                    >
                        <span class="px-2 py-2 dark:text-white">
                            {{ option.name }}
                        </span>

                        <div
                            class="flex items-center justify-center w-24 dark:bg-green-700"
                            v-if="selectionIndex.includes(option.id)"
                        >
                            <span class="font-medium dark:text-white"
                                >Ausgewählt</span
                            >
                        </div>
                    </div>
                </div>

                <p class="mt-2 ml-1 dark:text-gray-600">
                    <em
                        >{{ selectionIndex.length }}/{{
                            poll.max_check
                        }}
                        Antworten ausgewählt</em
                    >
                </p>
            </div>

            <LoadingButton
                :disabled="!(selectionIndex.length === poll.max_check)"
                :loading="sending"
                type="submit"
                @submit.prevent="vote"
                class="px-3 py-2 font-semibold rounded-lg dark:text-white dark:bg-green-700"
                :class="{
                    'dark-hover:bg-green-800':
                        selectionIndex.length === poll.max_check,
                }"
            >
                Abstimmen
            </LoadingButton>
        </form>

        <inertia-link
            :href="route('polls.abstain', this.poll.id)"
            method="post"
            class="block mt-3 dark:text-white"
        >
            Ich möchte mich enthalten.
        </inertia-link>
    </div>
</template>

<script>
import LoadingButton from "@/Shared/UI/LoadingButton.vue";
import Icon from "@/Shared/Icon.vue";

export default {
    name: "PollVote",
    components: { Icon, LoadingButton },
    props: {
        poll: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectionIndex: [],
            query: "",
            sending: false,
        };
    },
    methods: {
        vote() {
            const payload = {
                poll_id: this.poll.id,
                options: this.selectionIndex,
            };
            this.sending = true;
            this.$inertia.post(
                this.route("polls.vote", this.poll.id),
                payload,
                {
                    onSuccess: () => {
                        this.sending = false;
                    },
                }
            );
        },
        abstain() {
            this.$inertia.post();
        },
        clickedOption(id) {
            if (this.poll.is_radio) {
                this.selectionIndex = [];
                this.selectionIndex.push(id);
            } else {
                if (this.selectionIndex.includes(id)) {
                    const index = this.selectionIndex.indexOf(id);
                    this.selectionIndex.splice(index, 1);
                } else {
                    if (this.selectionIndex.length < this.poll.max_check) {
                        this.selectionIndex.push(id);
                    }
                }
            }
        },
    },
    computed: {
        filteredOptions() {
            if (this.query === "") {
                return this.poll.options;
            } else {
                let query = this.query.toLowerCase();
                return this.poll.options.filter(function (option) {
                    return option.name.toLowerCase().includes(query);
                });
            }
        },
    },
};
</script>

<style scoped></style>
