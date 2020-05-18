<template>
  <div class="form-group input-wrapper">
    <label v-if="label">
      {{label}}
    </label>
    <multiselect
      v-bind="$attrs"
      :options="options"
      :label="selectLabel"
      :track-by="trackBy"
      v-model="computedModel"
      @input="$emit('input', $event)"
    >
    </multiselect>
    <div v-for="(error, index) in errors" :key="index" :value="error" class="text-danger error">
      {{ error }}
    </div>
  </div>
</template>
<script>
  export default {
    inheritAttrs: false,
    // modelの設定を行う
    model: {
      prop: 'modelProps', // 親モデルの値を'modelProps'というkeyで受け取るよ
      event: 'change' // 親モデルに伝達するイベント種別
    },
    props: {
      value: [String, Number],
      label: String,
      options: Array,
      selectLabel: String,
      trackBy: String,
      errors: Array,
      modelProps: {
        type: Object | null, // 親モデルの値が入ってくるので、型を指定してあげる
        default: null,
      },
    },
    computed: {
      computedModel: {
        get () {
          // propsで受け取った親モデルの値をcomputedModelに反映する
          return this.modelProps
        },
        set (value) {
          // computedModelの値が変更された際はここに入ってくる
          // $emitで親コンポーネントのmodelに反映する
          this.$emit('change', value)
        }
      }
    },
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
