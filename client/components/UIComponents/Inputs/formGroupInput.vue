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
    <div v-for="(error, index) in errors" :key="index" :value="error" class="text-danger error">
      {{ error }}
    </div>
  </div>
</template>
<script>
  export default {
    inheritAttrs: false,
    props: {
      value: [String, Number],
      label: String,
      errors: Array,
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

  .error {
    padding-top: 5px;
    font-size: 14px;
  }
</style>
