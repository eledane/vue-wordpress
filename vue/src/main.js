// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
// import 'bootstrap/dist/css/bootstrap.min.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.config.productionTip = false

Vue.use(VueAxios, axios)
Vue.axios.defaults.baseURL = 'http://www.vue-wordpress.loc/ely/api/v1'
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
