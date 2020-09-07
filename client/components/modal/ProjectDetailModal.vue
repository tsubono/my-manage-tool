<template>
  <div id="project-detail-modal">
    <ModalWrapper @close="onClickClose()">
      <h3 slot="header" class="row">
        <!-- タイトル -->
        <span class="col-md-10 col-sm-10">{{ project.name }}詳細</span>
        <!-- /タイトル -->
      </h3>
      <template slot="body">
        <!-- コンテンツ -->
        <div class="row">
          <div class="col-sm-7">
            <div class="item-row">
              <label>取引先</label>
              {{ project.client.name }}
            </div>
            <div class="item-row">
              <label>ステータス</label>
              <div class="status-label" :style="{'background': project.status.color}">
                {{ project.status.name }}
              </div>
            </div>
            <div class="item-row">
              <label>内容</label>
              {{ project.content }}
            </div>
            <div class="item-row">
              <label>金額</label>
              {{ project.price | price }} 円
            </div>
            <div class="item-row">
              <label>開始日</label>
              {{ project.start_date }}
            </div>
            <div class="item-row">
              <label>終了日</label>
              {{ project.limit_date }}
            </div>
            <div class="item-row">
              <label>ラベル</label>
              <div class="labels">
                <div v-for="label  in project.labels" class="label">
                  {{ label.name }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="item-row">
              <label>外注先</label>
              <div v-for="subcontractor  in project.subcontractors" class="subcontractor-item">
                <img :src="$utility.getImageUrl(subcontractor.icon_path)">
                <div class="person">
                  {{ subcontractor.name }}
                </div>
                <div class="price">
                  {{ subcontractor.pivot.price |price }} 円
                </div>
              </div>
            </div>
            <div class="item-row">
              <div class="price-item">
                <label>受注合計</label>
                {{ project.price | price  }} 円
              </div>
              <div class="price-item">
                <label>外注合計</label>
                <span class="text-danger">{{ subcontractor_total_price | price  }} 円</span>
              </div>
              <div class="price-item">
                <label>利益</label>
                <span class="text-primary">{{ project.price - subcontractor_total_price | price  }} 円</span>
              </div>
            </div>
          </div>
        </div>
        <!-- /コンテンツ -->
      </template>
      <!-- フッター -->
      <template slot="footer">
        <button class="btn btn-default" @click="onClickClose">
          閉じる
        </button>
      </template>
      <!-- /フッター -->
    </ModalWrapper>
  </div>
</template>

<script>
  import ModalWrapper from '~/components/modal/ModalWrapper'

  export default {
    name: 'project-detail-modal',
    components: {
      ModalWrapper,
    },
    props: {
      project: {
        type: Object,
        default: () => ({
          id: null,
          name: null,
          client: {},
          status: {},
          content: null,
          price: 0,
          start_date: null,
          limit_date: null,
          subcontractors: [],
          labels: [],
        })
      },
    },
    computed: {
      subcontractor_total_price() {
        if (this.project.subcontractors.length !== 0) {
          return this.project.subcontractors.reduce((prev, current) => prev.pivot.price + current.pivot.price);
        } else {
          return 0;
        }
      },
    },
    methods: {
      onClickClose() {
        this.$emit('close');
      },
    },
  }
</script>

<style lang="scss" scoped>
  #project-detail-modal {
    .item-row {
      display: flex;
      flex-direction: column;
      font-size: 1.6rem;
      margin-bottom: 20px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 20px;

      .subcontractor-item {
        display: flex;
        margin-bottom: 10px;
        line-height: 50px;

        img {
          width: 50px;
          height: 50px;
          border-radius: 50%;
        }

        .person {
          margin-left: 15px;
        }

        .price {
          margin-left: 15px;
        }
      }

      .price-item {
        label {
          width: 50%;
        }

        span.text-primary {
          font-size: 2rem;
        }
      }
    }

    .status-label {
      padding: 10px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
      width: 300px;
      text-align: center;
      white-space: nowrap;
    }

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
  }
</style>
