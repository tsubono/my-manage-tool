<template>
  <div class="markdown-editor">
    <no-ssr>
      <mavon-editor
        :toolbars="markdownOption"
        language="ja"
        v-model="computedModel"
        placeholder="メモ内容"
        @imgAdd="imgAdd"
        ref="md"
      />
    </no-ssr>
    <div v-for="(error, index) in errors" :key="index" :value="error" class="text-danger error">
      {{ error }}
    </div>
  </div>
</template>

<script>
  export default {
    // modelの設定を行う
    model: {
      prop: 'modelProps', // 親モデルの値を'modelProps'というkeyで受け取るよ
      event: 'change' // 親モデルに伝達するイベント種別
    },
    props: {
      modelProps: {
        type: Object | null,
        default: null,
      },
      errors: Array,
    },
    data() {
      return {
        markdownOption: {
          bold: true,
          italic: true,
          header: true,
          underline: true,
          strikethrough: true,
          mark: true,
          quote: true,
          ol: true,
          ul: true,
          link: true,
          imagelink: true,
          code: true,
          table: true,
          fullscreen: true,
          htmlcode: true,
        },
      };
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
      async imgAdd(pos, $file) {
        let formData = new FormData();
        formData.append('file', $file);
        // アップロード
        await this.$axios.$post('/file/upload', formData)
          .then((response) => {
            this.$refs.md.$img2Url(pos, response.file_path);
          })
          .catch((error) => {
            this.$utility.notifyError(this.$notifications, 'ファイルのアップロードに失敗しました');
          });
      },
    }
  };
</script>

<style scoped>
  .markdown-editor {
    width: 100%;
    height: 100%;
  }
  .markdown-body {
    min-height: 400px;
  }
</style>
