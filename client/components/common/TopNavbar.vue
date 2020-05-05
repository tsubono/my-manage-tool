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
        <a class="navbar-brand">{{routeName}}</a>
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
      routeName() {
        const { name } = this.$route;
        return this.capitalizeFirstLetter(name);
      }
    },
    data() {
      return {
        activeNotifications: false
      }
    },
    methods: {
      ...mapActions('app', ['fetchStudyBooks']),
      capitalizeFirstLetter(string) {
        return string !== null ? string.charAt(0).toUpperCase() + string.slice(1) : null
      },
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
