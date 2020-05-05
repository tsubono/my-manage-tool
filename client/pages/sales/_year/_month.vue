<template>
  <div id="sale-list">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="year-month col-md-4 col-xs-12 text-center">
              <nuxt-link
                :to="{ name:'sales-year-month',
                  params: { year: beforeYear, month: beforeMonth } }">
                <span class="ti-arrow-circle-left"></span>
              </nuxt-link>
              <span>{{ $route.params.year }}年{{ $route.params.month }}月</span>
              <nuxt-link
                :to="{ name:'sales-year-month',
                  params: { year: nextYear, month: nextMonth } }">
                <span class="ti-arrow-circle-right"></span>
              </nuxt-link>
            </div>
            <div class="total-price col-md-4 col-xs-9">
              Total: <span>{{ totalPrice | price }}円</span>
            </div>
            <div class="analysis col-md-2 col-xs-3">
              <nuxt-link :to="{ name:'sales-year-analysis', params: { year: $route.params.year } }">
                <button class="btn btn-success">分析</button>
              </nuxt-link>
            </div>
            <!-- .add-button -->
            <div class="text-right add-button col-md-2">
              <button class="btn btn-primary" @click="onClickAdd()">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- sale list -->
            <div class="content table-responsive table-full-width">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th v-for="column in table.columns" :key="column">{{ column }}</th>
                </tr>
                </thead>
                <tbody>
                <!-- sale row -->
                <tr v-for="(item, index) in sales" :key="index">
                  <td v-for="column in table.columns" :key="column" v-if="item[column && column.toLowerCase()] !== 'undefined'">
                    <!-- projectの場合はリンク -->
                    <nuxt-link :to="{ name:'projects-id', params: { id: item.project.id } }" v-if="column === 'Project'">
                      {{ item.project.name}}
                    </nuxt-link>
                    <!-- statusの場合はラベル -->
                    <span class="status-label" :style="{'background': item.status.color}" v-else-if="column === 'Status'">
                      {{ item.status.name }}
                    </span>
                    <!-- priceの場合は金額表示 -->
                    <span v-else-if="column === 'Price'">{{ item[column.toLowerCase()] | price }}</span>

                    <!-- 他はテキスト表示 -->
                    <span v-else>{{ item[column.toLowerCase()] }}</span>
                  </td>
                  <td>
                    <div class="d-flex actions">
                      <a @click="onClickEdit(item)">
                        <span class="ti-pencil-alt"></span>
                      </a>
                      <a @click="destroy">
                        <span class="ti-trash text-danger"></span>
                      </a>
                    </div>
                  </td>
                </tr>
                <!-- /sale row -->
                </tbody>
              </table>
            </div>
            <!-- /sale list -->
          </div>
        </div>
      </div>
    <SaleModal
      v-if="isShowSaleModal"
      :item="showModalItem"
      :projectOptions="$utility.getProjectOptions(projects)"
      :statusOptions="$utility.getStatusOptions(statuses)"
      @close="closeSaleModal()"
    />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import SaleModal from '~/components/modal/SaleModal'

  export default {
    layout: 'default',
    components: {
      SaleModal,
    },
    head() {
      return {
        title: '売上一覧',
      }
    },
    async fetch ({ store, route }) {
      await Promise.all([
        store.dispatch('sale/fetchByMonth',
          {
            year: route.params.year,
            month: route.params.month,
          }),
        store.dispatch('sale/fetchStatus'),
        store.dispatch('project/fetch'),
      ]);

    },
    data() {
      return {
        table: {
          title: '売上一覧',
          columns: ['Project', 'Planned_Deposit_Date', 'Price', 'Status', ''],
        },
        isShowSaleModal: false,
        showModalItem: {},
      }
    },
    computed: {
      ...mapState('sale', ['sales', 'statuses']),
      ...mapState('project', ['projects']),
      beforeYear() {
        const year = Number(this.$route.params.year);
        const month = Number(this.$route.params.month);
        return (month - 1) === 0 ? year - 1 : year;
      },
      nextYear() {
        const year = Number(this.$route.params.year);
        const month = Number(this.$route.params.month);
        return (month + 1) === 13 ? year + 1 : year;
      },
      beforeMonth() {
        const month = Number(this.$route.params.month);
        return (month - 1) === 0 ? 12 : month - 1;
      },
      nextMonth() {
        const month = Number(this.$route.params.month);
        return (month + 1) === 13 ? 1 : month + 1;
      },
      totalPrice() {
        let totalPrice = 0;
        this.sales.forEach((sale) => {
          totalPrice += sale.price;
        });
        return totalPrice;
      }
    },
    methods: {
      onClickEdit(item) {
        this.isShowSaleModal = true;
        this.showModalItem = item;
      },
      onClickAdd() {
        this.isShowSaleModal = true;
      },
      onClickDelete() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 削除APIに飛ばす！
        }
      },
      closeSaleModal() {
        this.isShowSaleModal = false;
        this.showModalItem = {};
      },
      destroy() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 削除APIに飛ばす！
        }
      },
    }
  }
</script>

<style lang="scss" scoped>
  #sale-list {
    .year-month {
      padding: 20px;
      font-size: 25px;

      a {
        padding: 5px;
        color: #777;
      }
    }

    .total-price {
      padding: 15px;
      font-size: 20px;

      span {
        font-size: 30px;
        color: #3490DC;
      }
    }

    .analysis {
      padding: 15px;
    }

    .status-label {
      padding: 10px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
    }

    .add-button {
      padding: 10px;
    }

    .actions {
      span {
        font-size: 20px;
        margin-left: 10px;
      }
    }
  }
</style>
