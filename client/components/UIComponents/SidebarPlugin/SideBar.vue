<template>
  <div :class="sidebarClasses"
       :data-background-color="backgroundColor"
       :data-active-color="activeColor">
    <div class="sidebar-wrapper">
      <div class="logo">
        <a href="#" class="simple-text">
          <img
            :src="$utility.getImageUrl(user.icon_path)"
            class="round-img small icon-img">
          {{ user.name }}
        </a>
      </div>

      <slot name="content"></slot>
      <ul :class="navClasses">
        <slot>
          <sidebar-link
            v-for="(link,index) in sidebarLinks"
            :key="link.name + index"
            :to="link.path"
            @click="closeNavbar"
            :link="link">
            <i :class="link.icon"></i>
            <p>{{link.name}}</p>
          </sidebar-link>
        </slot>
      </ul>
    </div>
  </div>
</template>
<script>
  import SidebarLink from './SidebarLink.vue'
  import MovingArrow from './MovingArrow.vue'

  export default {
    components: {
      SidebarLink,
      MovingArrow
    },
    props: {
      title: {
        type: String,
        default: 'manage-tool'
      },
      type: {
        type: String,
        default: 'sidebar',
      },
      backgroundColor: {
        type: String,
        default: 'black',
        validator: (value) => {
          let acceptedValues = ['white', 'black', 'darkblue']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      backgroundImage: {
        type: String,
        default: 'static/img/icon.jpg'
      },
      activeColor: {
        type: String,
        default: 'success',
        validator: (value) => {
          let acceptedValues = ['primary', 'info', 'success', 'warning', 'danger']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      sidebarLinks: {
        type: Array,
        default: () => []
      },
      autoClose: {
        type: Boolean,
        default: true
      }
    },
    provide () {
      return {
        autoClose: this.autoClose
      }
    },
    computed: {
      sidebarClasses () {
        if (this.type === 'sidebar') {
          return 'sidebar'
        } else if (this.type === 'sidebar-mobile') {
          return 'sidebar sidebar-mobile'
        } else {
          return 'collapse navbar-collapse off-canvas-sidebar'
        }
      },
      navClasses () {
        if (this.type === 'sidebar') {
          return 'nav'
        } else if (this.type === 'sidebar-mobile') {
          return 'nav navbar-nav nav-mobile-menu'
        } else {
          return 'nav navbar-nav'
        }
      },
      user() {
        return this.$auth.user;
      }
    },
    data () {
      return {
        linkHeight: 60,
        activeLinkIndex: 0,
        windowWidth: 0,
        isWindows: false,
        hasAutoHeight: false
      }
    },
    methods: {
      findActiveLink () {
        this.sidebarLinks.find((element, index) => {
          let found = element.path === this.$route.path
          if (found) {
            this.activeLinkIndex = index
          }
          return found
        })
      }
    },
    mounted () {
      this.findActiveLink()
    },
    watch: {
      $route: function (newRoute, oldRoute) {
        this.findActiveLink()
      }
    }
  }
</script>

<style lang="scss" scoped>
  .icon-img {
    margin-right: 10px;
  }
</style>
