<template>
  <div id="project-record-list">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="header">
              <h4 class="title">案件情報</h4>
            </div>
            <div class="content">
              <div class="info-row">
                <label>案件名</label>
                <div>
                  {{ project.name }}
                </div>
              </div>
              <div class="info-row">
                <label>取引先</label>
                <div>
                  <nuxt-link :to="{ name:'clients-id', params: { id: project.client.id } }">
                    {{ project.client.name }}
                  </nuxt-link>
                </div>
              </div>
              <div class="info-row">
                <label>内容</label>
                <div class="text-value">{{ project.content }}</div>
              </div>
              <div class="info-row">
                <label>開始日</label>
                <div>
                  {{ project.start_date }}
                </div>
              </div>
              <div class="info-row">
                <label>終了日</label>
                <div>
                  {{ project.limit_date }}
                </div>
              </div>
              <div class="info-row">
                <label>ステータス</label>
                <div>
                    <span class="status-label" :style="{'background': project.status.color}">
                      {{ project.status.name }}
                    </span>
                </div>
              </div>
            </div>
          </div>
          <!-- TODO 累計時間 -->
          <div class="card">
            <div class="header">
              <h4 class="title">レコード一覧</h4>
            </div>
            <!-- .add-button -->
            <div class="text-right add-button">
              <button class="btn btn-primary" @click="onClickAdd()">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- TODO 年月移動 -->
            <!-- record list -->
            <div class="content table-responsive table-full-width">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th v-for="column in table.columns" :key="column">{{ column }}</th>
                </tr>
                </thead>
                <tbody>
                <!-- record row -->
                <tr v-for="(item, index) in project.records" :key="index">
                  <td v-for="column in table.columns" :key="column" v-if="item[column && column.toLowerCase()] !== 'undefined'">
                    <!-- 他はテキスト表示 -->
                    <span>{{ item[column.toLowerCase()] }}</span>
                  </td>
                  <td>
                    <div class="d-flex actions">
                      <a @click="onClickEdit(item)">
                        <span class="ti-pencil-alt"></span>
                      </a>
                      <span class="ti-trash text-danger" @click="onClickDelete(item.id)"></span>
                    </div>
                  </td>
                </tr>
                <tr v-if="projects.length === 0">
                  <td :colspan="table.columns.length" class="text-center">
                    データがありません
                  </td>
                </tr>
                <!-- /record row -->
                </tbody>
              </table>
            </div>
            <!-- /record list -->
          </div>
        </div>
      </div>
      <project-record-modal
        v-if="isShowRecordModal"
        :record="showModalItem"
        :project_id="$route.params.id"
        @close="closeRecordModal()"
      />
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import cloneDeep from 'lodash.clonedeep'
  import ProjectRecordModal from '~/components/modal/ProjectRecordModal'

  export default {
    layout: 'default',
    components: {
      ProjectRecordModal,
    },
    head() {
      return {
        title: '案件レコード一覧',
      }
    },
    async fetch ({ store }) {
      // TODO 年月別に取得
      await Promise.all([
        store.dispatch('project/fetch'),
      ]);
    },
    computed: {
      ...mapState('project', ['projects', 'statuses']),
      /**
       * IDにひもづく案件を取得
       *
       * @returns {[]}
       */
      project() {
        return cloneDeep(this.projects.find(data => data.id == this.$route.params.id));
      },
      labels() {
        return cloneDeep(this.projectLabels);
      },
    },
    data() {
      return {
        table: {
          title: 'レコード一覧',
          columns: ['Start_at', 'End_at', 'Content', ''],
        },
        isShowRecordModal: false,
        showModalItem: {},
      }
    },
    methods: {
      ...mapActions('projectRecord', ['destroy']),
      async onClickDelete(id) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.destroy(id);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
          } else {
            this.$utility.notifySuccess(this.$notifications, '削除が完了しました');
          }
        }
      },
      onClickEdit(item) {
        this.isShowRecordModal = true;
        this.showModalItem = cloneDeep(item);
      },
      onClickAdd() {
        this.isShowRecordModal = true;
      },
      async closeRecordModal() {
        await this.$store.dispatch('project/fetch');
        this.isShowRecordModal = false;
        this.showModalItem = {};
      },
    }
  }
</script>

<style lang="scss" scoped>
  #project-record-list {
    .status-label {
      padding: 10px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
    }
    .labels {
      .label {
        background: #9A9A9A;
        margin: 3px;
        border-radius: 10px;
        color: #fff;
        text-align: center;
      }
    }
    .actions {
      cursor: pointer;

      span {
        font-size: 20px;
        margin-left: 10px;
      }
    }
    .add-button {
      padding: 10px;
    }
    .info-row {
      display: flex;
      font-size: 17px;
      padding: 10px;

      label {
        margin-right: 10px;
      }
      .text-value {
        white-space: pre-wrap;
        word-wrap:break-word;
      }
    }
  }
</style>
