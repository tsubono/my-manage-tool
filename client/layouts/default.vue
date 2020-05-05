<template>
  <div :class="{'nav-open': sidebarStore.showSidebar}">
    <div class="wrapper">
      <Sidebar></Sidebar>
      <SidebarMobile></SidebarMobile>
      <no-ssr>
        <notifications></notifications>
      </no-ssr>
      <div class="main-panel">
        <top-navbar></top-navbar>
        <main-content></main-content>
        <content-footer></content-footer>
      </div>
    </div>
  </div>
</template>

<script>
  import Sidebar from '../components/common/Sidebar.vue'
  import SidebarMobile from '../components/common/SidebarMobile.vue'
  import TopNavbar from '../components/common/TopNavbar.vue'
  import MainContent from '../components/common/Content.vue'
  import ContentFooter from '../components/common/ContentFooter.vue'

  /**
   * 認証後の管理画面で使用するレイアウト
   */
  export default {
    middleware({ store, redirect }) {
      // 未認証の場合はリダイレクト
      if(!store.$auth.loggedIn) {
        redirect('/login');
      }
    },
    components: {
      Sidebar,
      SidebarMobile,
      TopNavbar,
      MainContent,
      ContentFooter,
    },
  }
</script>

<style lang="scss">
  @import "../assets/sass/paper-dashboard.scss";
  @import "../assets/sass/custom.scss";
</style>
