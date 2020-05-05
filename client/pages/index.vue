<template>
  <div id="top">
    <div class="row">
      <div class="col-lg-10 col-sm-12">
        <div class="card">
          <h3>Welcome <span class="ti-github"></span></h3>
          <div class="content">
            <div class="row">
              <div class="col-xs-10">
                <div class="message">
                  サンプル用に作成した管理画面サイトです。<br><br>
                  <span class="api ti-arrow-circle-down"> Api : Laravel v7.2 </span><br>
                  <span class="front ti-arrow-circle-down"> Front : Nuxt.js v2.12 </span><br>
                  <br>
                  <span class="ti-lock"></span> 一般ユーザーアカウントは、登録・更新・削除機能を制限しています。<br>
                  随時 機能追加中・・・🐈🐈🐈
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import StatsCard from '~/components/UIComponents/Cards/StatsCard.vue'

  export default {
    layout: 'default',
    head() {
      return {
        title: 'Top',
      }
    },
    components: {
      StatsCard,
    },
  }
</script>

<style lang="scss" scoped>
  #top {
    .card {
      padding: 20px 0;

      .content {
        padding: 0 15px 10px 15px;
      }
    }
    h3 {
      margin: 10px 0;
      position: relative;
      padding: 0.5em;
      background: #68B3C8;
      color: white;
    }
    .message {
      padding: 10px;
      line-height: 25px;

      span.api {
        color: #F66D9B;
        font-size: 18px;
        font-weight: bold;
      }
      span.front {
        color: #28A745;
        font-size: 18px;
        font-weight: bold;
      }
    }
  }
</style>
