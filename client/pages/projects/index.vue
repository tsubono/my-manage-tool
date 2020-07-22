<template>
  <div id="project-list">
      <div class="row">
        <div class="col-md-12">
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
                  <td v-for="column in table.columns" :key="column" v-if="item[column && column.toLowerCase()] !== 'undefined'">
                    <!-- clientの場合はリンク -->
                    <nuxt-link :to="{ name:'clients-id', params: { id: item.client.id } }" v-if="column === 'Client'">
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
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {
    layout: 'default',
    head() {
      return {
        title: '案件一覧',
      }
    },
    async fetch ({ store }) {
      await store.dispatch('project/fetch');
    },
    computed: {
      ...mapState('project', ['projects']),
    },
    data() {
      return {
        table: {
          title: '取引先一覧',
          columns: ['Name', 'Client', 'Status', 'Labels', ''],
        }
      }
    },
    methods: {
      ...mapActions('project', ['destroy']),
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
    .add-button {
      padding: 10px;
    }
  }
</style>
