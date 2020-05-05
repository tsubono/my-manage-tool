<template>
  <div class="markdown-editor">
    <no-ssr>
      <mavon-editor
        :toolbars="markdownOption"
        language="ja"
        v-model="model"
        placeholder="メモ内容"
      />
    </no-ssr>
  </div>
</template>

<script>
  export default {
    props: {
      modelProps: {
        type: Object | null,
        default: null,
      }
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
        model: this.modelProps,
      };
    },
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
