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
            <multiselect
              v-model="project.client"
              :options="clientOptions"
              label="name"
              track-by="id"
              placeholder="取引先"
              @input="option => form.client_id = (option !== null ? option.id : null)"
            >
            </multiselect>
            <!-- TODO: componentで纏めたい -->
            <div v-for="(error, index) in errors.client_id" :key="index" :value="error" class="text-danger error">
              {{ error }}
            </div>
          </div>
          <div class="form-group col-md-7 col-xs-12">
            <multiselect
              v-model="form.status"
              :options="$utility.getStatusOptions(statuses)"
              label="name"
              track-by="id"
              placeholder="ステータス"
              @input="option => form.status_id = (option !== null ? option.id : null)"
            >
            </multiselect>
            <!-- TODO: componentで纏めたい -->
            <div v-for="(error, index) in errors.status_id" :key="index" :value="error" class="text-danger error">
              {{ error }}
            </div>
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
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="開始日"
            v-model="form.start_date"
            :errors="errors.start_date"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-10 col-xs-12"
            label="納期"
            v-model="form.limit_date"
            :errors="errors.limit_date"
          >
          </fg-input>
          <div class="form-group col-md-10 col-xs-12">
            <multiselect
              v-model="form.labels"
              :options="labelOptions"
              open-direction="top"
              multiple
              taggable
              label="name"
              track-by="id"
              @tag="addLabel"
              tag-placeholder="新しいラベルを作成"
              placeholder="ラベル">
            </multiselect>
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
  export default {
    components: {
      StatusModal,
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
