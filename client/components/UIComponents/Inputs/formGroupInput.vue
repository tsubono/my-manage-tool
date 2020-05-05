<template>
  <div class="form-group input-wrapper">
    <label v-if="label">
      {{label}}
    </label>
    <input class="form-control border-input"
           v-bind="$attrs"
           :value="value"
           @input="updateValue($event.target.value)"
           v-on:input="model=$event.target.value">
  </div>
</template>
<script>
  export default {
    inheritAttrs: false,
    props: {
      value: [String, Number],
      label: String
    },
    methods: {
      updateValue(value) {
        this.$emit('input', String(value));
      }
  }
}
</script>
<style lang="scss" scoped>
  .input-wrapper {
    padding:0;
  }
</style>
