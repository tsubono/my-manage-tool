<template>
  <div id="top">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <h3>DashBoard</h3>
          <div class="content">
            <div class="row">
<!--              <div class="col-xs-10">-->
<!--                <div class="message">-->
<!--                  サンプル用に作成した管理画面サイトです。<br><br>-->
<!--                  <span class="api ti-arrow-circle-down"> Api : Laravel v7.2 </span><br>-->
<!--                  <span class="front ti-arrow-circle-down"> Front : Nuxt.js v2.12 </span><br>-->
<!--                  <br>-->
<!--                  <span class="ti-lock"></span> 一般ユーザーアカウントは、登録・更新・削除機能を制限しています。<br>-->
<!--                  随時 機能追加中・・・🐈🐈🐈-->
<!--                </div>-->
<!--              </div>-->
              <div class="col-xs-11">
                <div class="todo">
                  <h4>TODO</h4>
                  <div class="list">
                    <div class="row item" v-for="(item, index) in todos" :key="item.title">
                      <div class="title-label col-md-7 col-xs-12">
                        <input type="checkbox" name="checkbox" :id="'checkbox' + index" :checked="item.status"
                               @change="onClickTodoCheckBox(item.id, !item.status)"
                        />
                        <label :for="'checkbox' + index">{{ item.title }}</label>
                      </div>
                      <div class="limit col-md-3 col-xs-12 text-right" :class="{danger: !item.status && item.is_warning}">
                        <span class="ti-calendar"></span>
                        <span class="datetime">{{ item.limit_datetime === null ? '期限なし' : item.limit_datetime }}</span>
                      </div>
                    </div>
                    <div v-if="todos.length === 0">
                      ありません
                    </div>
                  </div>
                  <button class="btn btn-primary btn-fill todo-link" @click="$router.push('/todos')">
                    TODO管理へ
                  </button>
                </div>
                <div class="information">
                  <h4>Info</h4>
                  <div class="information-list">
                    ありません
                  </div>
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
  import { mapState, mapActions } from 'vuex'

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
    async fetch ({ store }) {
      await store.dispatch('todo/fetchCurrent');
    },
    computed: {
      ...mapState('todo', ['todos']),
    },
    methods: {
      ...mapActions('todo', ['toggleStatus']),
      async onClickTodoCheckBox(id, status) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.toggleStatus({ id: id, status: status });
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
          } else {
            const successMessage = status ? '完了にしました' : '未完了にしました';
            this.$utility.notifySuccess(this.$notifications, successMessage);
          }
        }
      },
    }
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

    .information {
      padding: 0.5em;
    }

    h4 {
      padding: 10px 0 10px 0;
      border-bottom: 1px solid;
    }

    .todo {
      padding: 0.5em;

      .todo-link {
        float: right;
      }

      .list {
        padding: 0 15px 30px 15px;
        min-height: 200px;

        .item {
          width: 90%;
          border-bottom: 1px dotted #9A9A9A;
          margin-bottom: 10px;
          padding: 10px;

          label {
            cursor: pointer;

            &:before {
              display: inline-block;
              content: "";
              margin: 0 10px 0 0;
              width: 35px;
              height: 35px;
              border: 3px solid #229863;
              border-radius: 100%;
              vertical-align: middle;
              color: #229863;
              font-size: 30px;
              text-align: center;
              font-weight: 700;
              line-height: 1.1em;
              transition: transform 0.2s ease-in-out;
            }
          }

          input[type=checkbox]:checked + label:before {
            background: #229863;
            color: #fff;
            transform: rotate(360deg);
            transform-origin: center center;
            content: "\02713";
          }

          input[type=checkbox] {
            visibility: hidden;
            position: absolute;
          }

          .limit {
            text-align: right;
            margin-top: 10px;

            &.danger {
              color: #EB5E28;
              font-weight: bold;
            }

            .datetime {
              padding-left: 5px;
            }
          }
        }
      }

      @media (max-width: 480px) {
        .list {
          padding: 0 0 30px 0;
          margin: 15px;

          .item {
            width: 100%;
            flex-direction: column;
            margin: 0 auto;
            padding: 0;

            .title-label {
              padding: 10px 0;
            }

            label {
              text-align: center;
            }
          }
        }
      }
    }
  }
</style>
