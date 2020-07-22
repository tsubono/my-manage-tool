<template>
  <div class="card col-md-10 col-md-offset-1">
    <!-- .header -->
    <div class="header">
      <h4 class="title">案件情報</h4>
    </div>
    <!-- /.header -->
    <!-- .content -->
    <div class="content">
      <!-- form items -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group col-md-10 col-xs-12">
            <fg-select
              v-model="form.client"
              :options="clientOptions"
              label="取引先"
              select-label="name"
              track-by="id"
              placeholder="取引先"
              :errors="errors.client_id"
              @input="$event => form.client_id = ($event !== null ? $event.id : null)"
            >
            </fg-select>
          </div>
          <div class="form-group col-md-7 col-xs-12">
            <fg-select
              v-model="form.status"
              :options="$utility.getStatusOptions(statuses)"
              label="ステータス"
              select-label="name"
              track-by="id"
              placeholder="ステータス"
              :errors="errors.status_id"
              @input="$event => form.status_id = ($event !== null ? $event.id : null)"
            >
            </fg-select>
          </div>
          <div class="form-group col-md-2 col-md-offset-1 col-xs-12">
            <button class="btn btn-success btn-wd" @click="toggleStatusModal">
              ステータス管理
            </button>
          </div>
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="名前"
            v-model="form.name"
            :errors="errors.name"
          >
          </fg-input>
          <div class="form-group col-md-10 col-xs-12">
            <label>内容</label>
            <textarea
              rows="5"
              class="form-control border-input"
              v-model="form.content"
              :errors="errors.content"
            ></textarea>
          </div>
          <div class="form-group input-wrapper col-md-10 col-xs-12">
            <label>
              開始日
            </label>
            <Datetime
              v-model="form.start_date"
              :format="'YYYY-MM-DD'"
              :overlay="true"
              :onlyDate="true"
            ></Datetime>
          </div>
          <div class="form-group input-wrapper col-md-10 col-xs-12">
            <label>
              納期
            </label>
            <Datetime
              v-model="form.limit_date"
              :format="'YYYY-MM-DD'"
              :overlay="true"
              :onlyDate="true"
            ></Datetime>
          </div>
          <div class="form-group col-md-10 col-xs-12">
            <fg-multi-select
              :labelOptions="labelOptions"
              open-direction="top"
              select-label="name"
              track-by="id"
              tag-placeholder="新しいラベルを作成"
              @add-label="addLabel"
              v-model="form.labels"
            >
            </fg-multi-select>
          </div>
        </div>
      </div>
      <!-- /form items -->
      <!-- buttons -->
      <div class="text-center actions">
        <button class="btn btn-default" @click="$router.push('/projects')">
          一覧に戻る
        </button>
        <button class="btn btn-info btn-fill btn-wd" @click="submit">
          {{ project.id === null ? "登録する" : "更新する" }}
        </button>
      </div>
      <!-- /buttons -->
    </div>
    <!-- /.content -->
    <status-modal
      v-if="isShowStatusModal"
      :statuses="statuses"
      @update="updateProjectStatuses"
      @close="toggleStatusModal"
    />
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import StatusModal from '~/components/modal/StatusModal'
  import Datetime from 'vue-ctk-date-time-picker'

  export default {
    components: {
      StatusModal,
      Datetime,
    },
    head () {
      return {
        bodyAttrs: {
          class: this.isShowStatusModal ? 'modal-body-background' : ''
        }
      }
    },
    props: {
      project: {
        type: Object,
        'default': () => ({
          id: null,
          client_id: null,
          name: null,
          content: null,
          start_date: null,
          limit_date: null,
          status_id: null,
          client: [],
          labels: [],
          status: [],
        })
      },
      clientOptions: {
        type: Array,
        'default': () => []
      },
      statuses: {
        type: Array,
        'default': () => []
      },
      labelOptions: {
        type: Array,
        'default': () => []
      },
      errors: {
        type: Object,
        'default': () => {}
      },
    },
    data() {
      return {
        form: this.project,
        isShowStatusModal: false,
      }
    },
    methods: {
      ...mapActions('project', ['updateStatuses']),
      toggleStatusModal() {
        this.isShowStatusModal = !this.isShowStatusModal;
      },
      async updateProjectStatuses({ formStatuses, deletedStatusIds }) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.updateStatuses({ statuses: formStatuses, deletedStatusIds: deletedStatusIds });
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.errors = response.errors;
              debugger
            }
          } else {
            this.$utility.notifySuccess(this.$notifications, '更新が完了しました');
            this.toggleStatusModal();
          }
        }
      },
      submit() {
        this.$emit('submit', this.form)
      },
      addLabel: function(newLabel) {
        const label = {
          id: newLabel.substring(0, 2) + Math.floor((Math.random() * 10000000)),
          name: newLabel,
        };
        this.labelOptions.push(label);
        this.form.labels.push(label);
      },
    }
  }
</script>

<style lang="scss" scoped>
  .icon-area {
    text-align: center;
    padding-top: 15px;

    .edit-icon {
      position: relative;
      top: 70px;
      right: 45px;
      cursor: pointer;
      font-size: 20px;
      border-radius: 50%;
      background: #ABB9BF;
      padding: 10px;
      color: #fff;

      &:hover {
        opacity: 0.9;
      }
    }
  }

  .actions {
    margin: 15px auto;
  }
</style>
