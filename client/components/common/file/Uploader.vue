<template>
  <label class="input-file-label">
    <slot name="button"></slot>
    <input type="file" @change="onImageSelected($event)" accept="image/*" class="hide">
  </label>
</template>

<script>
  export default {
    methods: {
      async onImageSelected(event) {
        const file = (event.target.files || event.dataTransfer)[0];
        const formData = new FormData();
        formData.append('file', file);

        // アップロード
        await this.$axios.$post('/file/upload', formData)
          .then((response) => {
            this.$emit('on-change-file', response.file_path)
          })
          .catch((error) => {
            this.$utility.notifyError(this.$notifications, 'ファイルのアップロードに失敗しました');
          });
      },
    }
  };
</script>
