<template>
  <div>
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
              <fg-select
                v-model="sale.project"
                :options="projectOptions"
                label="案件"
                select-label="name"
                track-by="id"
                placeholder="案件"
                :errors="errors.project_id"
                @input="$event => form.project_id = ($event !== null ? $event.id : null)"
              >
              </fg-select>
            </div>
            <div class="form-group input-wrapper col-md-10 col-md-offset-1 col-xs-12">
              <label>
                入金予定日
              </label>
              <Datetime
                v-model="form.planned_deposit_date"
                :format="'YYYY-MM-DD'"
                :overlay="true"
                :onlyDate="true"
              ></Datetime>
            </div>
            <div class="form-group input-wrapper col-md-10 col-md-offset-1 col-xs-12">
              <label>
                入金日
              </label>
              <Datetime
                v-model="form.deposit_date"
                :format="'YYYY-MM-DD'"
                :overlay="true"
                :onlyDate="true"
              ></Datetime>
            </div>
            <fg-input
              type="number"
              class="col-md-10 col-md-offset-1 col-xs-12"
              label="金額"
              v-model="form.price"
              :errors="errors.price"
            >
            </fg-input>
            <div class="form-group col-md-10 col-md-offset-1 col-xs-12">
              <label>備考</label>
              <textarea
                rows="5"
                class="form-control border-input"
                v-model="form.note"
                :errors="errors.note"
              >
              </textarea>
            </div>
            <div class="form-group col-md-7 col-md-offset-1 col-xs-12">
              <fg-select
                v-model="sale.status"
                :options="$utility.getStatusOptions(statuses)"
                label="ステータス"
                select-label="name"
                track-by="id"
                placeholder="ステータス"
                :errors="errors.sale_status_id"
                @input="$event => form.sale_status_id = ($event !== null ? $event.id : null)"
              >
              </fg-select>
            </div>
            <div class="form-group col-md-2 col-md-offset-1 col-xs-12">
              <br>
              <button class="btn btn-success btn-wd" @click="toggleStatusModal">
                ステータス管理
              </button>
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
        <button class="btn btn-primary" @click="onClickStore" v-if="sale.id === undefined">
          登録
        </button>
        <button class="btn btn-primary" @click="onClickUpdate" v-else>
          更新
        </button>
      </template>
      <!-- /フッター -->
    </ModalWrapper>
    <status-modal
      v-if="isShowStatusModal"
      :statuses="statuses"
      @update="updateSaleStatuses"
      @close="toggleStatusModal"
    />
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import ModalWrapper from '~/components/modal/ModalWrapper'
  import StatusModal from '~/components/modal/StatusModal'
  import Datetime from 'vue-ctk-date-time-picker'

  export default {
    name: 'sale-modal',
    components: {
      ModalWrapper,
      StatusModal,
      Datetime,
    },
    props: {
      sale: {
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
      statuses: {
        type: Array,
        'default': () => []
      },
    },
    data() {
      return {
        form: this.sale,
        errors: [],
        isShowStatusModal: false,
      }
    },
    methods: {
      ...mapActions('sale', ['store', 'update', 'destroy', 'updateStatuses']),
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
            this.$router.push({ name:'sales-year-month', params: { year: new Date(this.form.planned_deposit_date).getFullYear(), month: new Date(this.form.planned_deposit_date).getMonth() + 1 } });
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
            this.$router.push({ name:'sales-year-month', params: { year: new Date(this.form.planned_deposit_date).getFullYear(), month: new Date(this.form.planned_deposit_date).getMonth() + 1 } });
            this.$emit('close');
          }
        }
      },
      toggleStatusModal() {
        this.isShowStatusModal = !this.isShowStatusModal;
      },
      async updateSaleStatuses({ formStatuses, deletedStatusIds }) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.updateStatuses({ statuses: formStatuses, deletedStatusIds: deletedStatusIds });
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
            }
          } else {
            this.$utility.notifySuccess(this.$notifications, '更新が完了しました');
            this.toggleStatusModal();
          }
        }
      },
    }
  }
</script>
