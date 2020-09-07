import Vue from 'vue'

Vue.filter('price', function (value) {
  return value !== 0 ? Number(value).toLocaleString() : 0;
})
