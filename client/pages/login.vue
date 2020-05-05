<template>
  <div id="login">
    <div class="card">
      <div class="header">
        <h4 class="title">Login</h4>
      </div>
      <div class="content">
        <div class="login-form">
          <fg-input v-model="user.email" placeholder="メールアドレス"></fg-input>
          <fg-input v-model="user.password" placeholder="パスワード" type="password"></fg-input>
          <button class="btn btn-info btn-fill btn-wd" @click="login">
            ログイン
          </button>
          <div v-if="error" class="text-danger error">
            {{ error }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    layout: 'unauthenticated',
    auth: 'guest',
    head() {
      return {
        title: 'ログイン',
      }
    },
    data() {
      return {
        user: {
          email: "user1@user.com",
          password: "password1",
        },
        error: null,
      }
    },
    methods: {
      /**
       * 認証処理
       *
       * @returns {Promise<void>}
       */
      async login() {
        try {
          await this.$auth.loginWith('local', {data: this.user});
        } catch (error) {
          this.error = '認証情報をご確認ください';
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  #login {
    width: 360px;
    margin: 0 auto;
    padding: 10px;
    text-align: center;
    height: 550px;

    .login-form {
      padding: 2em;

      .error {
        margin-top: 10px;
      }
    }
  }
</style>
