require('dotenv').config();
const { APP_URL, API_URL } = process.env;
export default {
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: '%s',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" },
      { rel: 'stylesheet', href: "https://fonts.googleapis.com/css?family=Muli:400,300" },
      { rel: 'stylesheet', href: "https://fonts.googleapis.com/css?family=Montserrat" },
      { rel: 'stylesheet', href: "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" },
      { rel: 'stylesheet', href: "/css/themify-icons.css" },
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: {
    color: '#3B8070',
  },
  /*
  ** Global CSS
  */
  css: [
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    { src: '~/plugins/dashboard' },
    { src: '~/plugins/globalComponents' },
    { src: '~/plugins/globalDirectives' },
    { src: '~/plugins/axios.js' },
    { src: '~/plugins/utility.js' },
    { src: '@/plugins/vue-mavon-editor', ssr: false },
    { src: '~/plugins/filter' },
  ],
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/dotenv',
    '@nuxtjs/auth',
    'nuxt-vue-multiselect',
    '@nuxtjs/markdownit',
  ],
  /*
  ** Axios module configuration
  ** See https://axios.nuxtjs.org/options
  */
  axios: {
    // See https://github.com/nuxt-community/axios-module#options
    baseURL: API_URL
  },
  router: {
    linkExactActiveClass: 'active',
    base: '/'
  },
  auth: {
    redirect: {
      login: '/login',
      logout: '/login',
      callback: false,
      home: '/',
    },
    strategies: {
      local: {
        endpoints: {
          login: { url: '/auth/token', method: 'post', propertyName: 'token' },
          user: { url: '/auth/me', method: 'get', propertyName: false},
          logout: false
        }
      }
    }
  },
  markdownit: {
    injected: true,
    breaks: true,
    html: true,
    linkify: true,
    typography: true,
  },
  /*
  ** Build configuration
  */
  build: {
    /*
     ** Run ESLint on save
     */
    extend(config) {
      if (process.server && process.browser) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
