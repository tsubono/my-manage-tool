<template>
  <ModalWrapper @close="onClickClose()">
    <h3 slot="header" class="row">
      <!-- タイトル -->
      <fg-input class="col-md-10 col-sm-10" v-model="form.title" placeholder="タイトル" v-if="isEdit"></fg-input>
      <span class="col-md-10 col-sm-10" v-else>{{ item.title }}</span>
      <!-- /タイトル -->
      <!-- 切り替えボタン -->
      <template v-if="!isNew">
        <button class="btn toggle-btn col-md-1 col-sm-1" :class="{active: !isEdit}" @click="toggleEdit">
          <span class="ti-image"></span>
        </button>
        <button class="btn toggle-btn col-md-1 col-sm-1" :class="{active: isEdit}" @click="toggleEdit">
          <span class="ti-pencil"></span>
        </button>
      </template>
      <!-- /切り替えボタン -->
    </h3>
    <template slot="body">
      <!-- コンテンツ -->
      <MarkdownEditor v-if="isEdit" :modelProps="form.content" />
      <div v-html="$md.render(item.content)" v-else></div>
      <!-- /コンテンツ -->
    </template>
    <!-- フッター -->
    <template slot="footer">
      <button class="btn btn-default" @click="onClickClose">
        閉じる
      </button>
      <button class="btn btn-primary" @click="onClickUpdate" v-if="isEdit">
        更新
      </button>
    </template>
    <!-- /フッター -->
  </ModalWrapper>
</template>

<script>
  import ModalWrapper from '~/components/modal/ModalWrapper'
  import MarkdownEditor from '~/components/common/MarkdownEditor'

  export default {
    name: 'memo-modal',
    components: {
      ModalWrapper,
      MarkdownEditor,
    },
    props: {
      item: {
        type: Object,
        default: () => ({
            title: '',
            content: '',
          })
      },
      isNew: {
        type: Boolean,
        default: false,
      }
    },
    data() {
      return {
        isEdit: this.isNew,
        tabs: [
          {
            label: `<span class="ti-image"></span>`,
            onClick: this.toggleEdit,
            isActive: !this.isEdit,
          },
          {
            label: `<span class="ti-pencil"></span>`,
            onClick: this.toggleEdit,
            isActive: this.isEdit,
          },
        ],
        form: this.item
      }
    },
    methods: {
      toggleEdit() {
        this.isEdit = !this.isEdit;
      },
      onClickClose() {
        this.$emit('close');
      },
      onClickUpdate() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 更新APIに飛ばす！
        }
      },
    }
  }
</script>

<style lang="scss" scoped>
  .toggle-btn {
    border-radius: 0;
    background-color: #FFFFFF;
    border-color: #7A9E9F;
    color: #7A9E9F;

    &.active,
    &:hover,
    &:focus {
      background-color: #7A9E9F;
      border-color: #7A9E9F;
      color: #FFFFFF;
    }
  }
</style>
