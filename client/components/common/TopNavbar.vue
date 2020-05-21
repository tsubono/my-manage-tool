<template>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" :class="{'toggled': sidebarStore.showSidebar}" @click="toggleSidebar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar bar1"></span>
          <span class="icon-bar bar2"></span>
          <span class="icon-bar bar3"></span>
        </button>
        <a class="navbar-brand">{{ headerTitle }}</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <drop-down title="Settings" icon="ti-settings">
            <li><a href="" @click="logout">Logout</a></li>
          </drop-down>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
  import { mapActions } from 'vuex'
  export default {
    computed: {
      headerTitle() {
        const { name } = this.$route;
        if (name.match(/clients/)) {
          return '取引先管理'
        }
        if (name.match(/projects/)) {
          return '案件管理'
        }
        if (name.match(/todos/)) {
          return 'TODO'
        }
        if (name.match(/memos/)) {
          return 'メモ'
        }
        if (name.match(/sales/)) {
          return '売上'
        }
        if (name.match(/analysis/)) {
          return '分析'
        }
        if (name.match(/account/)) {
          return 'アカウント設定'
        }
      }
    },
    data() {
      return {
        activeNotifications: false
      }
    },
    methods: {
      closeDropDown() {
        this.activeNotifications = false
      },
      hideSidebar() {
        this.$sidebar.displaySidebar(false)
      },
      toggleSidebar() {
        this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
      },
      logout() {
        this.$auth.logout();
      },
    }
  }
</script>
