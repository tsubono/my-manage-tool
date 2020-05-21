<template>
  <div id="todo-list">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- .add-button -->
            <div class="text-right add-button">
              <button class="btn btn-primary" @click="onClickAdd()">
                <span class="ti-plus"></span>
              </button>
            </div>
            <!-- /.add-button -->
            <!-- list -->
            <div class="list">
              <div class="row item" v-for="(item, index) in todos" :key="item.title">
                <!-- 編集中の場合 -->
                <template v-if="isEdit && form.id === item.id">
                  <div class="title-input col-md-7 col-xs-12">
                    <fg-input
                      type="text"
                      v-model="form.title"
                      placeholder="タイトル"
                      :errors="errors[item.id] !== undefined ? errors[item.id].title : null"
                    ></fg-input>
                  </div>
                  <div class="limit-input col-md-3 col-xs-9 text-right">
                    <Datetime
                      v-model="form.limit_datetime"
                      :minute-interval="15"
                      :format="'YYYY-MM-DD HH:mm:ss'"
                      :overlay="true"
                    ></Datetime>
                  </div>
                  <div class="actions col-md-2 col-xs-12 text-right">
                    <a class="update-btn" @click="onClickUpdate"><span class="ti-arrow-circle-down"></span></a>
                    <button class="btn btn-danger btn-sm minus-btn" @click="onClickDelete(item.id)">
                      <span class="ti-minus"></span>
                    </button>
                  </div>
                </template>
                <!-- /編集中の場合 -->

                <!-- 初期表示の場合 -->
                <template v-else>
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
                  <div class="actions col-md-2 col-xs-12 text-right">
                    <a class="edit-btn" @click="onClickEdit(item)"><span class="ti-pencil-alt"></span></a>
                    <button class="btn btn-danger btn-sm minus-btn" @click="onClickDelete(item.id)">
                      <span class="ti-minus"></span>
                    </button>
                  </div>
                </template>
                <!-- /初期表示の場合 -->
              </div>

              <!-- +ボタン押下で追加されたレコード -->
              <div class="row item" v-for="(item, index) in newTodos" :key="index">
                <div class="title-input col-md-7 col-xs-12">
                  <fg-input
                    type="text"
                    v-model="item.title"
                    placeholder="タイトル"
                    :errors="errors['new-' + index] !== undefined ? errors['new-' + index].title : null"
                  ></fg-input>
                </div>
                <div class="limit-input col-md-3 col-xs-9 text-right">
                  <Datetime
                    v-model="item.limit_datetime"
                    :minute-interval="15"
                    :format="'YYYY-MM-DD HH:mm:ss'"
                    :overlay="true"
                  ></Datetime>
                  <template v-if="errors['new-' + index] !== undefined">
                    <div v-for="(error, errorIndex) in errors['new-' + index].limit_datetime" :key="errorIndex" :value="error" class="text-danger error">
                      {{ error }}
                    </div>
                  </template>
                </div>
                <div class="actions col-md-2 col-xs-12 text-right">
                  <a class="update-btn" @click="onClickStore(index, item)"><span class="ti-arrow-circle-down"></span></a>
                  <button class="btn btn-danger btn-sm minus-btn" @click="onClickDeleteNewTodos(index)">
                    <span class="ti-minus"></span>
                  </button>
                </div>
              </div>
              <!-- /追加されたレコード -->

              <div v-if="todos.length === 0 && newTodos.length === 0">
                データがありません
              </div>
            </div>
            <!-- / list -->
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import Datetime from 'vue-ctk-date-time-picker'
  import '@/node_modules/vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'

  export default {
    layout: 'default',
    head() {
      return {
        title: 'TODO一覧',
      }
    },
    components: {
      Datetime
    },
    async fetch ({ store }) {
      await store.dispatch('todo/fetch');
    },
    data() {
      return {
        form: {
          id: null,
          title: null,
          limit_datetime: null,
        },
        isEdit: false,
        newTodos: [],
        errors: [],
      }
    },
    computed: {
      ...mapState('todo', ['todos']),
    },
    methods: {
      ...mapActions('todo', ['store', 'update', 'destroy', 'toggleStatus']),
      onClickEdit(item) {
        this.errors[this.form.id] = undefined;
        this.isEdit = true;
        this.form.id = item.id;
        this.form.title = item.title;
        this.form.limit_datetime = item.limit_datetime;
      },
      onClickAdd() {
        this.newTodos.push({
          id: null,
          title: null,
          limit_datetime: null,
        })
      },
      onClickDeleteNewTodos(index) {
        this.newTodos.splice(index, 1);
      },
      async onClickStore(index, item) {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.store(item);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.$set(this.errors, 'new-' + index, response.errors);
            }
          } else {
            this.errors['new-' + index] = undefined;
            this.$utility.notifySuccess(this.$notifications, '登録が完了しました');
            this.newTodos.splice(index, 1);
          }
        }
      },
      async onClickUpdate() {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          const response = await this.update(this.form);
          if (response.isError !== undefined) {
            this.$utility.notifyError(this.$notifications, response.errorMessage !== undefined ? response.errorMessage : null);
            if (response.errors !== undefined) {
              this.$set(this.errors, this.form.id, response.errors);
            }
          } else {
            this.errors[this.form.id] = undefined;
            this.$utility.notifySuccess(this.$notifications, '更新が完了しました');
            this.isEdit = false;
            this.form = {
              id: null,
              title: null,
              limit_datetime: null,
            };
          }
        }
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
  #todo-list {
    .list {
      margin: 10px 30px;
      padding: 0 15px 30px 15px;
      min-height: 200px;

      .item {
        width: 90%;
        border-bottom: 1px dotted #9A9A9A;
        margin-bottom: 10px;
        padding: 10px;

        label {
          cursor: pointer;
          &:before{
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

        input[type=checkbox]:checked + label:before{
          background: #229863;
          color: #fff;
          transform:rotate(360deg);
          transform-origin: center center;
          content: "\02713";
        }

        input[type=checkbox] {
          visibility: hidden;
          position: absolute;
        }

        .form-group {
          margin-bottom: 0;
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

        .limit-input {
          padding: 0;
        }

        .actions {
          .edit-btn {
            position: relative;
            top: 6px;
            right: 10px;

            span {
              font-size: 25px;
            }
          }

          .update-btn {
            position: relative;
            top: 8px;
            right: 10px;
            color: #41B883;

            span {
              font-size: 30px;
            }
          }

          .minus-btn {
            cursor: pointer;
            height: 35px;
          }
        }
      }
    }

    .add-button {
      padding: 10px;
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

          .title-input {
            padding-top: 30px;
          }

          .limit-input {
            padding-top: 12px;
            float: right;
          }

          label {
            text-align: center;
          }

          .actions {
            padding: 10px;
          }

        }
      }
      .pickers-container {
        height: 100%;
      }
      .time-picker {
        max-height: 200px;
      }
    }
  }
</style>
