<template>
  <div>
    <ModalWrapper @close="onClickClose()">
      <h3 slot="header" class="row">
        <!-- タイトル -->
        <span class="col-md-10 col-sm-10">レコード更新</span>
        <!-- /タイトル -->
      </h3>
      <template slot="body">
        <!-- コンテンツ -->
        <div class="row">
          <div class="col-sm-12">
            <!-- TODO: コンポーネント化 -->
            <div class="form-group input-wrapper">
              <label>
                開始日時
              </label>
              <Datetime
                v-model="form.start_at"
                :format="'YYYY-MM-DD HH:mm:ss'"
                :overlay="true"
              ></Datetime>
              <template v-if="errors.start_at!== undefined">
                <div v-for="(error, errorIndex) in errors.start_at" :key="errorIndex" :value="error" class="text-danger error">
                  {{ error }}
                </div>
              </template>
            </div>
            <!-- TODO: コンポーネント化 -->
            <div class="form-group input-wrapper">
              <label>
                終了日時
              </label>
              <Datetime
                v-model="form.end_at"
                :format="'YYYY-MM-DD HH:mm:ss'"
                :overlay="true"
              ></Datetime>
              <template v-if="errors.end_at!== undefined">
                <div v-for="(error, errorIndex) in errors.end_at" :key="errorIndex" :value="error" class="text-danger error">
                  {{ error }}
                </div>
              </template>
            </div>

            <div class="form-group">
              <label>内容</label>
              <textarea
                rows="5"
                class="form-control border-input"
                v-model="form.content"
                :errors="errors.content"
              >
              </textarea>
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
        <button class="btn btn-primary" @click="onClickStore" v-if="record.id === undefined">
          登録
        </button>
        <button class="btn btn-primary" @click="onClickUpdate" v-else>
          更新
        </button>
      </template>
      <!-- /フッター -->
    </ModalWrapper>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import ModalWrapper from '~/components/modal/ModalWrapper'
  import Datetime from 'vue-ctk-date-time-picker'

  export default {
    name: 'project-record-modal',
    components: {
      ModalWrapper,
      Datetime,
    },
    props: {
      record: {
        type: Object,
        default: () => ({
          id: null,
          start_at: null,
          end_at: null,
          content: null,
        })
      },
      project_id: String,
    },
    data() {
      return {
        form: {
          project_id: this.project_id,
          ...this.record
        },
        errors: [],
      }
    },
    methods: {
      ...mapActions('projectRecord', ['store', 'update', 'destroy']),
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
            // this.$router.push({ name:'sales-year-month', params: { year: new Date(this.form.planned_deposit_date).getFullYear(), month: new Date(this.form.planned_deposit_date).getMonth() + 1 } });
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
            // this.$router.push({ name:'sales-year-month', params: { year: new Date(this.form.planned_deposit_date).getFullYear(), month: new Date(this.form.planned_deposit_date).getMonth() + 1 } });
            this.$emit('close');
          }
        }
      },
    }
  }
</script>
