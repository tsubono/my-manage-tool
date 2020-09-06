<template>
  <div id="project-list">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="content">
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <fg-input
                  type="text"
                  class="col-md-10 col-xs-12"
                  label="名前"
                  v-model="searchForm.name"
                >
                </fg-input>
              </div>
              <div class="col-md-6 col-xs-12">
                <fg-select
                  :options="$utility.getStatusOptions(statuses)"
                  label="ステータス"
                  select-label="name"
                  track-by="id"
                  @input="$event => searchForm.status_id = ($event !== null ? $event.id : null)"
                  v-model="searchForm.status"
                >
                </fg-select>
              </div>
              <div class="col-md-6 col-xs-12">
                <fg-multi-select
                  :labelOptions="labels"
                  label="ラベル"
                  open-direction="top"
                  select-label="name"
                  track-by="id"
                  v-model="searchForm.labels"
                  :taggable="false"
                >
                </fg-multi-select>
              </div>
            </div>
          </div>
          <div class="footer text-center row search-btn-area">
            <div class="col-md-4 col-xs-12">
              <button class="btn btn-default reset-btn" @click="resetSearch">
                リセット
              </button>
            </div>
            <div class="col-md-6 col-xs-12">
              <button class="btn btn-fill search-btn" @click="submitSearch">
                <span class="ti-search"></span> 検索
              </button>
            </div>
          </div>
        </div>
        <div class="card">
          <!-- .add-button -->
          <div class="text-right add-button">
            <button class="btn btn-primary" @click="$router.push('/projects/new')">
              <span class="ti-plus"></span>
            </button>
          </div>
          <!-- /.add-button -->
          <!-- project list -->
          <div class="content table-responsive table-full-width">
            <table class="table table-striped">
              <thead>
              <tr>
                <th v-for="column in table.columns" :key="column">{{ column }}</th>
              </tr>
              </thead>
              <tbody>
              <!-- project row -->
              <tr v-for="(item, index) in projects" :key="index">
                <td v-for="column in table.columns" :key="column"
                    v-if="item[column && column.toLowerCase()] !== 'undefined'">
                  <!-- nameの場合はリンク -->
                  <a v-if="column === 'Name'" @click="toggleShowDetailModal(item)">
                    {{ item.name}}
                  </a>
                  <!-- clientの場合はリンク -->
                  <nuxt-link :to="{ name:'clients-id', params: { id: item.client.id } }" v-else-if="column === 'Client'">
                    {{ item.client.name}}
                  </nuxt-link>
                  <!-- statusの場合はラベル -->
                  <span class="status-label" :style="{'background': item.status.color}" v-else-if="column === 'Status'">
                      {{ item.status.name }}
                    </span>
                  <!-- Labelsの場合はラベル -->
                  <div class="labels" v-else-if="column === 'Labels'">
                    <div class="label" v-for="label in item.labels" :key="label.name">
                      {{ label.name }}
                    </div>
                  </div>
                  <span v-else-if="column === 'Price'">
                   {{ item[column.toLowerCase()] | price }} 円
                  </span>
                  <span class="limit-date" :class="{'text-danger': new Date(item.limit_date).getTime() <= new Date().getTime()}" v-else-if="column === 'LimitDate'">
                   {{ item.limit_date }}
                  </span>
                  <!-- 他はテキスト表示 -->
                  <span v-else>{{ item[column.toLowerCase()] }}</span>
                </td>
                <td>
                  <div class="d-flex actions">
                    <nuxt-link :to="{ name:'projects-id', params: { id: item.id } }">
                      <span class="ti-pencil-alt"></span>
                    </nuxt-link>
                    <nuxt-link :to="{ name:'projects-id-records', params: { id: item.id } }">
                      <span class="ti-time"></span>
                    </nuxt-link>
                    <span class="ti-trash text-danger" @click="onClickDelete(item.id)"></span>
                  </div>
                </td>
              </tr>
              <tr v-if="projects.length === 0">
                <td :colspan="table.columns.length" class="text-center">
                  データがありません
                </td>
              </tr>
              <!-- /project row -->
              </tbody>
            </table>
          </div>
          <!-- /project list -->
        </div>
      </div>
    </div>
    <project-detail-modal
      v-if="showDetailModal"
      :project="showProject"
      @close="toggleShowDetailModal()"
    />
  </div>
</template>

<script>
  import {mapState, mapActions} from 'vuex'
  import cloneDeep from 'lodash.clonedeep'
  import Datetime from 'vue-ctk-date-time-picker'
  import ProjectDetailModal from '~/components/modal/ProjectDetailModal'

  export default {
    layout: 'default',
    components: {
      Datetime,
      ProjectDetailModal,
    },
    head() {
      return {
        title: '案件一覧',
      }
    },
    async fetch({store}) {
      await Promise.all([
        store.dispatch('project/fetch'),
        store.dispatch('label/fetch'),
      ]);
    },
    computed: {
      ...mapState('project', ['projects', 'statuses']),
      ...mapState('label', ['projectLabels']),
      labels() {
        return cloneDeep(this.projectLabels);
      },
    },
    data() {
      return {
        table: {
          title: '取引先一覧',
          columns: ['Name', 'Client', 'Status', 'Labels', 'Price', 'LimitDate', ''],
        },
        searchForm: {
          name: null,
          labels: [],
          status: null,
        },
        showDetailModal: false,
        showProject: {},
      }
    },
    methods: {
      ...mapActions('project', ['search', 'destroy']),
      async toggleShowDetailModal(showProject = {}) {
        this.showDetailModal = !this.showDetailModal;
        this.showProject = showProject;
      },
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
      async submitSearch() {
        await this.$store.dispatch('project/fetch', this.searchForm);
      },
      async resetSearch() {
        await this.$store.dispatch('project/fetch');
      },
    }
  }
</script>

<style lang="scss" scoped>
  #project-list {
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

    .search-btn-area {
      width: 50%;
      margin: 0 auto;

      .search-btn {
        margin-bottom: 20px;
        width: 300px;
      }
    }

    .add-button {
      padding: 10px;
    }
  }
</style>
