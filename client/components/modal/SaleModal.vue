<template>
  <ModalWrapper @close="onClickClose()">
    <h3 slot="header" class="row">
      <!-- タイトル -->
      <span class="col-md-10 col-sm-10">売上更新</span>
      <!-- /タイトル -->
    </h3>
    <template slot="body">
      <!-- コンテンツ -->
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group col-md-10 col-md-offset-1 col-xs-12">
            <multiselect
              v-model="form.project"
              :options="projectOptions"
              label="name"
              track-by="id"
              placeholder="案件"
            >
            </multiselect>
          </div>
          <fg-input
            type="text"
            class="col-md-10 col-md-offset-1 col-xs-12"
            label="入金予定日"
            v-model="form.planned_deposit_date"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-10 col-md-offset-1 col-xs-12"
            label="入金日"
            v-model="form.planned_deposit_date"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-10 col-md-offset-1 col-xs-12"
            label="金額"
            v-model="form.price"
          >
          </fg-input>
          <div class="form-group col-md-10 col-md-offset-1 col-xs-12">
            <label>備考</label>
            <textarea
              rows="5"
              class="form-control border-input"
              v-model="form.note"
            >
            </textarea>
          </div>
          <div class="form-group col-md-10 col-md-offset-1 col-xs-12">
            <multiselect
              v-model="form.status"
              :options="statusOptions"
              label="name"
              track-by="id"
              placeholder="ステータス">
            </multiselect>
          </div>
        </div>
      </div>
      <!-- /コンテンツ -->
    </template>
    <!-- フッター -->
    <template slot="footer">
      <button class="btn btn-default" @click="onClickClose">
        閉じる
      </button>
      <button class="btn btn-primary" @click="onClickUpdate">
        <span>{{ item.id !== undefined ? '更新' : '登録' }}</span>
      </button>
    </template>
    <!-- /フッター -->
  </ModalWrapper>
</template>

<script>
  import ModalWrapper from '~/components/modal/ModalWrapper'

  export default {
    name: 'sale-modal',
    components: {
      ModalWrapper,
    },
    props: {
      item: {
        type: Object,
        default: () => ({
          id: null,
          project_id: null,
          planned_deposit_date: null,
          deposit_date: null,
          price: null,
          sale_status_id: null,
          note: null,
        })
      },
      projectOptions: {
        type: Array,
        'default': () => []
      },
      statusOptions: {
        type: Array,
        'default': () => []
      },
    },
    data() {
      return {
        form: this.item
      }
    },
    methods: {
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
