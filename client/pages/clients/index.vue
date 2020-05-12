<template>
  <div id="client-list">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- .add-button -->
            <div class="text-right add-button">
              <button class="btn btn-primary" @click="$router.push('/clients/new')">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- client list -->
            <div class="content table-responsive table-full-width">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th v-for="column in table.columns" :key="column">{{ column }}</th>
                </tr>
                </thead>
                <tbody>
                <!-- client row -->
                <tr v-for="(item, index) in clients" :key="index">
                  <td v-for="column in table.columns" :key="column" v-if="item[column && column.toLowerCase()] !== 'undefined'">
                    <!-- Labelsの場合はラベル表示 -->
                    <div class="labels" v-if="column === 'Labels'">
                      <div class="label" v-for="label in item.labels" :key="label.name">
                        {{ label.name }}
                      </div>
                    </div>
                    <!-- アイコンの場合は画像表示 -->
                    <img
                      :src="$utility.getImageUrl(item.icon_path)"
                      width="50"
                      class="round-img"
                      v-else-if="column === 'iconPath'"
                    >
                    <!-- 他はテキスト表示 -->
                    <span v-else>{{ item[column.toLowerCase()] }}</span>
                  </td>
                  <td>
                    <div class="d-flex actions">
                      <nuxt-link :to="{ name:'clients-id', params: { id: item.id } }">
                        <span class="ti-pencil-alt"></span>
                      </nuxt-link>
                      <span class="ti-trash text-danger" @click="onClickDelete(item.id)"></span>
                    </div>
                  </td>
                </tr>
                <tr v-if="clients.length === 0">
                  <td :colspan="table.columns.length" class="text-center">
                    データがありません
                  </td>
                </tr>
                <!-- /client row -->
                </tbody>
              </table>
            </div>
            <!-- /client list -->
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
        title: '取引先一覧',
      }
    },
    async fetch ({ store }) {
      await store.dispatch('client/fetch');
    },
    computed: {
      ...mapState('client', ['clients']),
    },
    data() {
      return {
        table: {
          title: '取引先一覧',
          columns: ['iconPath', 'Name', 'Address', 'Labels', ''],
        }
      }
    },
    methods: {
      ...mapActions('client', ['destroy']),
      async onClickDelete(id) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.destroy(id);
          if (response.isError !== undefined) {
            if (response.errorMessage !== undefined) {
              this.$utility.notifyError(this.$notifications, this.errorMessage);
            }
          } else {
            this.$utility.notifySuccess(this.$notifications, '削除が完了しました');
          }
        }
      },
    }
  }
</script>

<style lang="scss" scoped>
  #client-list {
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
