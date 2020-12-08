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
          <div class="test-user">
            【 テストユーザー 】 <br>
            メールアドレス: test@test.com <br>
            パスワード: testUserPass <br>
          </div>
          <button class="btn btn-info btn-fill btn-wd" @click="login">
            ログイン
          </button>
          <div v-if="error" class="text-danger error">
            {{ error }}
          </div>
          <div class="register-link">
            <nuxt-link :to="{ name:'register' }">
              新規登録
            </nuxt-link>
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
          email: "",
          password: "",
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
    margin: 0 auto;
    padding: 10px;
    text-align: center;
    height: 550px;

    @media (min-width: 480px) {
      width: 360px;
    }

    .login-form {
      padding: 2em;

      .error {
        margin-top: 10px;
      }
    }

    .register-link {
      padding-top: 10px;
    }

    .test-user {
      font-size: 0.6rem;
      text-align: center;
      margin: 10px auto;
    }
  }
</style>
