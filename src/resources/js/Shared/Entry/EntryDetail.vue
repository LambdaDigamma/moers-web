<template>
    <div>
        <div class="flex items-center border-b border-gray-500">
            <button class="flex-shrink-0 p-2 my-3 ml-4" @click="$emit('close')">
                <svg
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    class="w-6 h-6 text-gray-900"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
            <div class="flex-1 ml-4">
                <h1 class="font-medium leading-none text-gray-900">Details</h1>
                <p class="mt-1 text-sm leading-none text-gray-600">Eintrag</p>
            </div>
        </div>
        <div class="relative pb-2/3">
            <img
                class="absolute object-cover w-full h-full"
                src="https://images.unsplash.com/photo-1464869372688-a93d806be852?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80"
            />
        </div>

        <div class="p-4 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-900">
                {{ entry.name }}
            </h1>
            <span class="text-base font-medium text-gray-600"
                >{{ entry.street }} {{ entry.house_number }}</span
            >
        </div>

        <div class="p-4 border-b border-gray-200 md:py-6">
            <PrimaryButton size="lg" block> Route </PrimaryButton>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="col-span-1">
                    <WhiteButton
                        size="lg"
                        block
                        :disabled="!entry.phone"
                        @click="copyPhone"
                    >
                        Anrufen
                    </WhiteButton>
                </div>
                <div class="col-span-1">
                    <WhiteButton
                        size="lg"
                        block
                        :disabled="!entry.url"
                        :href="entry.url ? entry.url : null"
                        target="_blank"
                    >
                        Webseite
                    </WhiteButton>
                </div>
            </div>
        </div>

        <div class="p-4 border-b border-gray-200">
            <div class="text-base text-gray-700">
                <h2 class="text-base font-medium text-gray-900">
                    Öffnungszeiten
                </h2>
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div class="col-span-1">Montag</div>
                    <div class="col-span-2">
                        {{ entry.monday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Dienstag</div>
                    <div class="col-span-2">
                        {{ entry.tuesday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Mittwoch</div>
                    <div class="col-span-2">
                        {{ entry.wednesday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Donnerstag</div>
                    <div class="col-span-2">
                        {{ entry.thursday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Freitag</div>
                    <div class="col-span-2">
                        {{ entry.friday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Samstag</div>
                    <div class="col-span-2">
                        {{ entry.saturday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Sonntag</div>
                    <div class="col-span-2">
                        {{ entry.sunday }}
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">Sonstiges</div>
                    <div class="col-span-2">
                        {{ entry.other }}
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Adresse</h2>

            <div class="text-gray-700">
                <p>{{ entry.street }} {{ entry.house_number }}</p>
                <p>{{ entry.postcode }} {{ entry.place }}</p>
            </div>
        </div>

        <div class="p-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Kontakt</h2>

            <div class="text-gray-700">
                <p v-if="entry.phone">Telefon: {{ entry.phone }}</p>
                <p v-if="entry.url">
                    Webseite:
                    <a
                        target="_blank"
                        class="hover:text-gray-700 hover:underline"
                        :href="entry.url"
                        >{{ entry.url }}</a
                    >
                </p>
            </div>
        </div>

        <div class="p-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Schlagworte</h2>
            <div class="flex flex-wrap mb-2">
                <span
                    v-for="(tag, index) in entry.tags"
                    :key="index"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-gray-200 text-gray-800 mr-2 mt-2"
                >
                    {{ tag }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import PrimaryButton from "../UI/PrimaryButton.vue";
import WhiteButton from "../UI/WhiteButton.vue";

export default {
    name: "EntryDetail",
    components: { WhiteButton, PrimaryButton },
    props: {
        entry: Object,
    },
    methods: {
        copyPhone() {
            if (this.entry.phone) {
                navigator.clipboard.writeText(this.entry.phone).then(
                    function () {
                        console.log(
                            "Async: Copying to clipboard was successful!"
                        );
                    },
                    function (err) {
                        console.error("Async: Could not copy text: ", err);
                    }
                );
            }
        },
    },
};
</script>

<style scoped></style>
