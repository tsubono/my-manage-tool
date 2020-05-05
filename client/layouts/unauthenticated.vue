<template>
  <div class="wrapper">
    <div class="main-panel full">
      <main-content></main-content>
      <content-footer></content-footer>
    </div>
  </div>
</template>

<script>
  import MainContent from '../components/common/Content.vue'
  import ContentFooter from '../components/common/ContentFooter.vue'

  /**
   * 認証前のページで使用するレイアウト
   */
  export default {
    middleware({ store, redirect }) {
      // 認証済みの場合はリダイレクト
      if(store.$auth.loggedIn) {
        redirect('/');
      }
    },
    components: {
      ContentFooter,
      MainContent
    },
  }
</script>

<style lang="scss" scoped>
  @import '../assets/sass/paper-dashboard.scss';
  @import "../assets/sass/custom.scss";
</style>
