<template>
    <div>
        <div class="flex flex-col h-64 bg-gray-100">
            <div
                class="px-4 py-5 overflow-y-auto sm:p-6"
                scroll-region
                id="scroll-container"
            >
                <div
                    v-for="message in messages"
                    :key="message.id"
                    class="flex flex-row mb-3"
                    :class="{
                        'justify-end': message.sender_id === $page.props.auth.user.id,
                    }"
                >
                    <div
                        class="w-1/2 px-3 py-2 text-sm rounded-md"
                        :class="[
                            message.sender_id === $page.props.auth.user.id
                                ? 'bg-blue-200'
                                : 'bg-red-200',
                        ]"
                    >
                        <p>{{ message.content }}</p>
                        <small
                            class="text-xs font-medium"
                            :class="[
                                message.sender_id === $page.props.auth.user.id
                                    ? 'text-blue-500'
                                    : 'text-red-500',
                            ]"
                        >
                            {{
                                message.created_at
                                    | moment("[um] hh:mm [am] DD.MM.")
                            }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex w-full px-4 py-2 bg-white rounded-lg shadow sm:p-6 md:py-3"
        >
            <label for="message_input" class="sr-only">
                Nachricht eingeben
            </label>
            <div
                class="relative w-full text-gray-400 focus-within:text-gray-600"
            >
                <button
                    class="absolute inset-y-0 left-0 flex items-center pointer-events-none"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                <input
                    id="message_input"
                    @keydown.enter="sendMessage"
                    v-model="form.message"
                    class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 rounded-md focus:outline-none focus:placeholder-gray-400 sm:text-sm"
                    placeholder="Nachricht eingeben"
                />
            </div>
            <button
                type="button"
                @click="sendMessage"
                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-blue-700 transition duration-150 ease-in-out bg-blue-100 border border-transparent rounded-md hover:bg-blue-50 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-blue-200"
            >
                Senden
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChatBox",
    props: {
        conversation: Object,
        messages: Array,
    },
    methods: {
        sendMessage() {
            this.$emit("send", this.form.message);
            this.form.message = null;
        },
    },
    data() {
        return {
            form: {
                message: null,
            },
        };
    },
    mounted() {
        Echo.private("conversation." + this.conversation.id).listen(
            ".message.posted",
            (e) => {
                this.messages.push(e.message);
                axios
                    .post(
                        this.route(
                            "conversations.readMessage",
                            this.conversation.id
                        )
                    )
                    .then((response) => {
                        console.log(response.data);
                    });
            }
        );
    },
    updated() {
        var container = this.$el.querySelector("#scroll-container");
        container.scrollTop = container.scrollHeight;
    },
};
</script>

<style scoped></style>
