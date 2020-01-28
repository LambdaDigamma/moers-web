<template>

    <div>
        <div class="mt-0">
            <h1 class="font-semibold text-2xl dark:text-white">{{ poll.question }}</h1>
            <p class="font-normal text-base dark:text-white">{{ poll.description }}</p>
        </div>

        <form @submit.prevent="vote">
            <div class="mt-2">

                <div class="my-3 flex items-stretch w-full">
                    <div class="flex items-center rounded-l pl-1 dark:bg-gray-800">
                        <icon name="search" class="h-4 w-4 m-2 dark:fill-white"></icon>
                    </div>
                    <input @keydown.enter.prevent="" v-model="query" placeholder="Suchen…" type="text" class="w-full px-2 py-2 md:px-2 md:py-3 rounded-r focus:shadow-outline dark:text-white dark:bg-gray-600" />
                </div>


                <div class="">
                    <div class="border-4 border-transparent dark:bg-gray-600 mt-1 rounded flex justify-between "
                         v-for="option in filteredOptions" :key="option.id"
                         @click="clickedOption(option.id)"
                         :class="{ 'border-green-700' : selectionIndex.includes(option.id) }">

                        <span class="px-2 py-2 dark:text-white">
                            {{ option.name }}
                        </span>

                        <div class="w-24 flex justify-center items-center dark:bg-green-700" v-if="selectionIndex.includes(option.id)">
                            <span class="font-medium dark:text-white">Ausgewählt</span>
                        </div>

                    </div>
                </div>

                <p class="mt-2 ml-1 dark:text-gray-600"><em>{{ selectionIndex.length }}/{{ poll.max_check }} Antworten ausgewählt</em></p>

            </div>

            <LoadingButton :disabled="!(selectionIndex.length === poll.max_check)"
                           :loading="sending"
                           type="submit"
                           @submit.prevent="vote"
                           class="px-3 py-2 font-semibold rounded-lg dark:text-white dark:bg-green-700"
                           :class="{ 'dark-hover:bg-green-800' : selectionIndex.length === poll.max_check }">
                Abstimmen
            </LoadingButton>

        </form>

        <inertia-link :href="route('polls.abstain', this.poll.id)"
                      method="post"
                      class="block mt-3 dark:text-white">
            Ich möchte mich enthalten.
        </inertia-link>

    </div>

</template>

<script>
import { ABSTAIN_POLL, VOTE_POLL } from "../store/actions.type";
import LoadingButton from "../Shared/LoadingButton";
import Icon from "../Shared/Icon";

export default {
    name: "PollVote",
    components: {Icon, LoadingButton},
    props: {
        poll: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            selectionIndex: [],
            query: "",
            sending: false,
        }
    },
    methods: {
        vote() {
            const payload = {
                poll_id: this.poll.id,
                options: this.selectionIndex
            }
            this.sending = true
            this.$inertia.post(this.route('polls.vote', this.poll.id), payload)
                .then(() => this.sending = false)
        },
        abstain() {
            this.$inertia.post()
        },
        clickedOption(id) {

            if (this.poll.is_radio) {
                this.selectionIndex = []
                this.selectionIndex.push(id)
            } else {
                if (this.selectionIndex.includes(id)) {
                    const index = this.selectionIndex.indexOf(id)
                    this.selectionIndex.splice(index, 1)
                } else {
                    if (this.selectionIndex.length < this.poll.max_check) {
                        this.selectionIndex.push(id)
                    }
                }
            }

        }
    },
    computed: {
        filteredOptions() {
            if (this.query === "") {
                return this.poll.options
            } else {
                let query = this.query.toLowerCase()
                return this.poll.options.filter(function(option) {
                    return option.name.toLowerCase().includes(query);
                })
            }
        }
    }
}

</script>

<style scoped>

</style>
