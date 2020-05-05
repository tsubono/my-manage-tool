<template>
  <div id="account">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <!-- .header -->
          <div class="header">
            <h4 class="title">アカウント設定</h4>
          </div>
          <!-- /.header -->
          <!-- .content -->
          <div class="content">
            <!-- .form -->
            <div class="form">
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <fg-input
                    type="text"
                    label="Name"
                    placeholder="ユーザー名"
                    v-model="user.name"
                  >
                  </fg-input>
                  <fg-input
                    type="email"
                    label="email"
                    placeholder="メールアドレス"
                    v-model="user.email"
                  >
                  </fg-input>
                  <fg-input
                    type="password"
                    label="Password"
                    placeholder="パスワード"
                    v-model="user.password"
                  >
                  </fg-input>
                </div>
              </div>
              <!-- button -->
              <div class="text-center">
                <button class="btn btn-info btn-fill btn-wd" @click="update">
                  更新する
                </button>
              </div>
              <!-- /button -->
            </div>
            <!-- /.form -->
          </div>
          <!-- /.content -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  /**
   * アカウント設定画面
   */
  export default {
    layout: 'default',
    head() {
      return {
        title: 'アカウント設定',
      }
    },
    computed: {
      user() {
        return this.$auth.user;
      }
    },
    data () {
      return {
        error: null
      }
    },
    methods: {
      update () {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          // TODO: 更新APIに飛ばす！
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  #account {
    .form {
      padding: 15px;
      color: #03bc06;
    }
  }
</style>
