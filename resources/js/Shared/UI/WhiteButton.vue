<template>
    <span
        class="inline-flex rounded-md shadow-sm"
        :class="{ 'w-full justify-center': block }"
    >
        <component
            class="inline-flex items-center font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300"
            v-bind="$attrs"
            :is="type"
            :href="href"
            :type="buttonType"
            :class="{
                'px-2.5 py-1.5 text-xs leading-4 rounded': size === 'xs',
                'px-3 py-2 text-sm leading-4 rounded-md': size === 'sm',
                'px-4 py-2 text-sm leading-6 rounded-md': size === 'md',
                'px-4 py-2 text-base leading-6 rounded-md': size === 'lg',
                'px-6 py-3 text-base leading-6 rounded-md': size === 'xl',
                'hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:text-gray-800 active:bg-gray-50':
                    !disabled,
                'opacity-50': disabled,
                'w-full justify-center': block,
            }"
            :target="target"
            @click="clickedButton($event)"
        >
            <slot></slot>
        </component>
    </span>
</template>

<script>
export default {
    name: "WhiteButton",
    inheritAttrs: false,
    props: {
        size: {
            validator: function (value) {
                return ["xs", "sm", "md", "lg", "xl"].indexOf(value) !== -1;
            },
            default: "md",
        },
        href: {
            type: String,
            required: false,
            default: null,
        },
        buttonType: {
            validator: function (value) {
                return ["button", "reset", "submit"].indexOf(value) !== -1;
            },
            default: null,
            required: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        block: {
            type: Boolean,
            default: false,
        },
        target: {
            type: String,
            required: false,
            default: () => "",
        },
    },
    computed: {
        type() {
            if (this.href) {
                return "inertia-link";
            } else {
                return "button";
            }
        },
    },
    methods: {
        clickedButton: function (e) {
            if (!this.disabled) {
                this.$emit("click", e);
            }
        },
    },
};
</script>

<style scoped></style>
