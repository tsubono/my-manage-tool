<template>
  <ModalWrapper @close="onClickClose()">
    <h3 slot="header" class="row">
      <!-- タイトル -->
      <fg-input
        class="col-md-10 col-sm-10"
        v-model="form.title" placeholder="タイトル"
        v-if="isEdit"
        :errors="errors.title"
      ></fg-input>
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
      <MarkdownEditor
        v-if="isEdit"
        v-model="form.content"
        :errors="errors.content"
      />
      <div v-html="$md.render(item.content)" v-else></div>
      <!-- /コンテンツ -->
    </template>
    <!-- フッター -->
    <template slot="footer">
      <button class="btn btn-default" @click="onClickClose">
        閉じる
      </button>
      <button class="btn btn-primary" @click="onClickStore" v-if="isNew">
        登録
      </button>
      <button class="btn btn-primary" @click="onClickUpdate" v-else-if="isEdit">
        更新
      </button>
      <button class="btn btn-danger" @click="onClickDelete" v-if="!isNew">
        削除
      </button>
    </template>
    <!-- /フッター -->
  </ModalWrapper>
</template>

<script>
  import { mapActions } from 'vuex'
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
            id: '',
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
        form: this.item,
        errors: [],
      }
    },
    methods: {
      ...mapActions('memo', ['store', 'update', 'destroy']),
      toggleEdit() {
        this.isEdit = !this.isEdit;
      },
      onClickClose() {
        this.$emit('close');
      },
      async onClickStore() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.store(this.form);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$emit('close');
          }
        }
      },
      async onClickUpdate() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.update(this.form);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$emit('close');
          }
        }
      },
      async onClickDelete() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.destroy(this.form.id);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$emit('close');
          }
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
