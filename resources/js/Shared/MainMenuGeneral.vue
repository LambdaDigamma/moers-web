<template>
    <div>
        <div class="md:mb-4">
            <inertia-link
                class="flex items-center py-2 group hover:no-underline"
                :href="route('dashboard')"
            >
                <icon
                    name="dashboard"
                    class="w-4 h-4 mr-2"
                    :class="
                        isUrl('dashboard')
                            ? 'fill-white'
                            : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'
                    "
                />
                <div
                    :class="
                        isUrl('dashboard')
                            ? 'text-white'
                            : 'text-gray-700 md:text-gray-600 group-hover:text-white'
                    "
                >
                    Übersicht
                </div>
            </inertia-link>
        </div>
        <div class="md:mb-4">
            <inertia-link
                class="flex items-center py-2 group hover:no-underline"
                :href="route('polls.index')"
            >
                <icon
                    name="pie-chart"
                    class="w-4 h-4 mr-2"
                    :class="
                        isUrl('polls')
                            ? 'fill-white'
                            : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'
                    "
                />
                <div
                    :class="
                        isUrl('polls')
                            ? 'text-white'
                            : 'text-gray-700 md:text-gray-600 group-hover:text-white'
                    "
                >
                    Abstimmungen
                </div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
import Icon from "@/Shared/Icon.vue";

export default {
    components: {
        Icon,
    },
    props: {
        url: String,
    },
    methods: {
        isUrl(...urls) {
            if (urls[0] === "") {
                return this.url === "";
            }

            return urls.filter((url) => this.url.startsWith(url)).length;
        },
    },
};
</script>
