<template>
  <div id="sale-analysis-list">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="year col-md-4 col-xs-12 text-center">
            <nuxt-link
              :to="{ name:'sales-year-analysis',
                  params: { year: Number($route.params.year) - 1 } }">
              <span class="ti-arrow-circle-left"></span>
            </nuxt-link>
            <span>{{ $route.params.year }}年</span>
            <nuxt-link
              :to="{ name:'sales-year-analysis',
                  params: { year: Number($route.params.year) + 1 } }">
              <span class="ti-arrow-circle-right"></span>
            </nuxt-link>
          </div>
          <div class="total-price col-md-3 col-xs-10">
            Total: <span>{{ totalPrice | price }}円</span><br>
            Average: <span>{{ Math.floor(priceAverage) | price }}円</span>
          </div>
          <div class="list col-md-3 col-xs-10">
            <nuxt-link :to="{ name:'sales-year-month', params: { year: $route.params.year, month: new Date().getMonth() + 1 } }">
              <button class="btn btn-success">売上一覧</button>
            </nuxt-link>
          </div>
          <div class="col-md-7 col-xs-12 chart-block">
            <div class="bar-chart">
              <SaleBarChart :priceList="priceListByMonth" :priceAverage="priceAverage" :height="300" />
            </div>
          </div>
          <div class="col-md-5 col-xs-12 chart-block">
            <div class="pie-chart">
              <SalePieChart :salesByClient="salesByClient" :height="300" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import SaleBarChart from '~/components/sale/BarChart'
  import SalePieChart from '~/components/sale/PieChart'

  export default {
    layout: 'default',
    components: {
      SaleBarChart,
      SalePieChart,
    },
    head() {
      return {
        title: '売上分析',
      }
    },
    async fetch ({ store, route }) {
      await Promise.all([
        store.dispatch('sale/fetchByYear', { year: route.params.year }),
        store.dispatch('sale/fetchByClient', { year: route.params.year }),
        store.dispatch('sale/fetchStatus'),
      ]);

    },
    computed: {
      ...mapState('sale', ['sales', 'salesByClient', 'statuses']),
      totalPrice() {
        let totalPrice = 0;
        this.sales.forEach((sale) => {
          totalPrice += Number(sale.price);
        });
        return totalPrice;
      },
      priceAverage() {
        let totalPrice = 0;
        this.priceListByMonth.forEach((price) => {
          totalPrice += Number(price);
        });

        return this.totalPrice / this.priceListByMonth.length;
      },
      priceListByMonth() {
        const priceList = [];
        for (let i = 0; i < 12; i++) {
          priceList[i] = 0;
        }
        this.sales.forEach((sale) => {
          let month = new Date(sale.planned_deposit_date).getMonth();
          priceList[month] += sale.price;
        });

        return priceList;
      },
    },
  }
</script>

<style lang="scss" scoped>
  #sale-analysis-list {
    .year {
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

    .list {
      padding: 15px;
    }

    .chart-block {
      margin-top: 35px;
    }

    .card {
      min-height: 600px;

      @media (max-width: 480px) {
        min-height: 950px;
      }
    }
  }
</style>
