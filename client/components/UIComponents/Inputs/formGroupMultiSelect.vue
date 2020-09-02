<template>
  <div class="form-group input-wrapper">
    <label v-if="label">
      {{label}}
    </label>
    <multiselect
      v-bind="$attrs"
      :options="labelOptions"
      :open-direction="openDirection"
      :label="selectLabel"
      :track-by="trackBy"
      :tag-placeholder="tagPlaceholder"
      @tag="addLabel"
      v-model="computedModel"
      multiple
      :taggable="taggable"
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
      labelOptions: Array,
      openDirection: String,
      selectLabel: String,
      trackBy: String,
      tagPlaceholder: String,
      errors: Array,
      modelProps: {
        type: Object | null, // 親モデルの値が入ってくるので、型を指定してあげる
        default: null,
      },
      taggable: {
        type: Boolean | null,
        default: true
      }
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
    methods: {
      addLabel: function (newLabel) {
        this.$emit('add-label', newLabel)
      },
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
