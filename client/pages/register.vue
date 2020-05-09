<template>
  <div id="register">
    <div class="card">
      <div class="header">
        <h4 class="title">Register</h4>
      </div>
      <div class="content">
        <div class="login-form">
          <fg-input v-model="user.name" placeholder="名前" :errors="errors.name"></fg-input>
          <fg-input v-model="user.email" placeholder="メールアドレス" :errors="errors.email"></fg-input>
          <fg-input v-model="user.password" placeholder="パスワード" type="password" :errors="errors.password"></fg-input>
          <button class="btn btn-info btn-fill btn-wd" @click="register">
            新規登録
          </button>
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
        title: '新規登録',
      }
    },
    data() {
      return {
        user: {
          name: null,
          email: null,
          password: null,
        },
        errors: {
          user: {
            name: null,
            email: null,
            password: null,
          }
        },
      }
    },
    methods: {
      /**
       * 新規登録処理
       *
       * @returns {Promise<void>}
       */
      async register() {
        await this.$axios.$post('/auth/register', this.user)
          .then(() => {
            this.$auth.loginWith('local', {data: this.user});
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.errors = err.response.data;
            }
          });
      }
    }
  }
</script>

<style lang="scss" scoped>
  #register {
    margin: 0 auto;
    padding: 10px;
    text-align: center;
    height: 550px;

    @media (min-width: 480px) {
      width: 360px;
    }

    .login-form {
      padding: 2em;
    }
  }
</style>
