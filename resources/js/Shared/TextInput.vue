<template>

  <div>

    <div v-if="label">
      <label :for="id">{{ label + ':' }}</label>
      <input :id="id"
             :value="value"
             :placeholder="placeholder"
             :type="type"
             v-bind="$attrs"
             @update="$emit('input', $event)"
             ref="input" />
      <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
      <slot />
    </div>

    <div v-else>
      <input :id="id"
             :value="value"
             :placeholder="placeholder"
             :type="type"
             v-bind="$attrs"
             @update="$emit('input', $event)"
             ref="input" />
      <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
      <slot />
    </div>

  </div>

</template>

<script>
  export default {
    name: "TextInput",
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `text-input-${this._uid}`
        },
      },
      type: {
        type: String,
        default: 'text',
      },
      value: String,
      label: String,
      placeholder: String,
      errors: {
        type: Array,
        default: () => [],
      },
      size: {
        type: String,
        default: () => 'md'
      }
    },
    methods: {
      focus() {
        this.$refs.input.focus()
      },
      select() {
        this.$refs.input.select()
      },
      setSelectionRange(start, end) {
        this.$refs.input.setSelectionRange(start, end)
      },
    },
  }
</script>

<style scoped>

</style>