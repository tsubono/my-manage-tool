<template>
  <div id="subcontractor-list">
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
              <button class="btn btn-primary" @click="$router.push('/subcontractors/new')">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- subcontractor list -->
            <div class="content table-responsive table-full-width">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th v-for="column in table.columns" :key="column">{{ column }}</th>
                </tr>
                </thead>
                <tbody>
                <!-- subcontractor row -->
                <tr v-for="(item, index) in subcontractors" :key="index">
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
                      <nuxt-link :to="{ name:'subcontractors-id', params: { id: item.id } }">
                        <span class="ti-pencil-alt"></span>
                      </nuxt-link>
                      <span class="ti-trash text-danger" @click="onClickDelete(item.id)"></span>
                    </div>
                  </td>
                </tr>
                <tr v-if="subcontractors.length === 0">
                  <td :colspan="table.columns.length" class="text-center">
                    データがありません
                  </td>
                </tr>
                <!-- /subcontractor row -->
                </tbody>
              </table>
            </div>
            <!-- /subcontractor list -->
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import cloneDeep from 'lodash.clonedeep'

  export default {
    layout: 'default',
    head() {
      return {
        title: '外注先一覧',
      }
    },
    async fetch ({ store }) {
      await Promise.all([
        store.dispatch('subcontractor/fetch'),
        store.dispatch('label/fetch'),
      ]);
    },
    computed: {
      ...mapState('subcontractor', ['subcontractors']),
      ...mapState('label', ['subcontractorLabels']),
      labels() {
        return cloneDeep(this.subcontractorLabels);
      },
    },
    data() {
      return {
        table: {
          title: '取引先一覧',
          columns: ['iconPath', 'Name', 'Labels', ''],
        },
        searchForm: {
          name: null,
          labels: [],
        }
      }
    },
    methods: {
      ...mapActions('subcontractor', ['destroy']),
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
        await this.$store.dispatch('subcontractor/fetch', this.searchForm);
      },
      async resetSearch() {
        await this.$store.dispatch('subcontractor/fetch');
      },
    }
  }
</script>

<style lang="scss" scoped>
  #subcontractor-list {
    .labels {
      display: flex;
      flex-wrap: wrap;

      .label {
        background: #9A9A9A;
        margin: 3px;
        border-radius: 10px;
        color: #fff;
        text-align: center;
        padding: 5px;
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
