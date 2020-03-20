<template>

    <span class="inline-flex rounded-md shadow-sm">
        <component
                class="inline-flex items-center border border-transparent font-medium text-white bg-blue-600 transition ease-in-out duration-150"
                :is="type"
                :href="href"
                :type="buttonType"
                :class="{
                'px-2.5 py-1.5 text-xs leading-4 rounded' : size === 'xs',
                'px-3 py-2 text-sm leading-4 rounded-md' : size === 'sm',
                'px-4 py-2 text-sm leading-5 rounded-md' : size === 'md',
                'px-4 py-2 text-base leading-6 rounded-md' : size === 'lg',
                'px-6 py-3 text-base leading-6 rounded-md' : size === 'xl',
                'hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700' : !disabled,
                'opacity-50' : disabled
                }"
                @click="clickedButton($event)">
            <slot></slot>
        </component>
    </span>

</template>

<script>
    export default {
        name: "PrimaryButton",
        props: {
            size: {
                validator: function (value) {
                    return ['xs', 'sm', 'md', 'lg', 'xl'].indexOf(value) !== -1
                },
                default: 'md'
            },
            href: {
                type: String,
                required: false,
                default: null
            },
            buttonType: {
                validator: function (value) {
                    return ['button', 'reset', 'submit'].indexOf(value) !== -1
                },
                default: null,
                required: false
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            type() {
                if (this.href) {
                    return 'a'
                } else {
                    return 'button'
                }
            }
        },
        methods: {
            clickedButton: function(e) {
                if (!this.disabled) {
                    this.$emit('click', e);
                }
            }
        }
    }
</script>

<style scoped>

</style>