<template>
  <ModalWrapper @close="onClickClose()">
    <h3 slot="header" class="row">
      <!-- タイトル -->
      <span class="col-md-10 col-sm-10">ステータス更新</span>
      <!-- /タイトル -->
    </h3>
    <template slot="body">
      <!-- コンテンツ -->
      <div class="row">
        <div class="col-sm-12 status-item" v-for="(formStatus, index) in formStatuses">
          <fg-input
            type="text"
            class="col-md-10 col-md-offset-1 col-xs-12"
            label="名称"
            v-model="formStatuses[index].name"
            :errors="errors['statuses.' + index + '.name'] !== undefined ? errors['statuses.' + index + '.name'] : []"
          >
          </fg-input>
          <color-picker-input
            type="text"
            class="col-md-10 col-md-offset-1 col-xs-12"
            label="色"
            v-model="formStatuses[index].color"
            :value="formStatuses[index].color"
            :errors="errors[index] !== undefined && errors[index].color !== undefined ? errors[index].color : []"
          />
          <button class="btn btn-danger btn-sm col-md-3 col-md-offset-9" @click="onClickDelete(formStatus, index)">
            削除
          </button>
        </div>
      </div>
      <div class="row">
        <button class="btn btn-success col-md-10 col-md-offset-1 col-sm-12" @click="onClickAdd">
          追加
        </button>
      </div>
      <!-- /コンテンツ -->
    </template>
    <!-- フッター -->
    <template slot="footer">
      <template v-if="errors['statuses'] !== undefined">
        <div v-for="(error, index) in errors['statuses']" :key="index" :value="error" class="text-danger error">
          {{ error }}
        </div>
      </template>
      <button class="btn btn-default" @click="onClickClose">
        閉じる
      </button>
      <button class="btn btn-primary" @click="onClickUpdate">
        <span>更新</span>
      </button>
    </template>
    <!-- /フッター -->
  </ModalWrapper>
</template>

<script>
  import ModalWrapper from '~/components/modal/ModalWrapper'
  import cloneDeep from 'lodash.clonedeep'
  import { Chrome } from 'vue-color'

  export default {
    name: 'sale-modal',
    components: {
      ModalWrapper,
      'chrome-picker': Chrome
    },
    props: {
      statuses: {
        type: Array,
        'default': () => []
      },
    },
    data() {
      return {
        formStatuses: cloneDeep(this.statuses),
        deletedStatusIds: [],
        errors: [],
      }
    },
    methods: {
      onClickAdd() {
        this.formStatuses.push({
          id: null,
          name: null,
          color: '#000000',
        })
      },
      onClickDelete(formStatus, index) {
        if (formStatus.id !== null) {
          this.deletedStatusIds.push(formStatus.id);
        }
        this.formStatuses.splice(index, 1);
      },
      onClickClose() {
        this.$emit('close');
      },
      async onClickUpdate() {
        this.$emit('update', {formStatuses: this.formStatuses, deletedStatusIds: this.deletedStatusIds});
      },
    }
  }
</script>

<style lang="scss" scoped>
  .status-item {
    &:not(:last-child) {
      border-bottom: 1px solid #CCC5B9;
    }
    padding: 10px;
  }
  .error {
    margin-bottom: 10px;
  }
</style>
