import Vue from 'vue'
import Vuex from 'vuex'
import Vuelidate from 'vuelidate'
import App from './App'
import router from './router'
import axios from 'axios'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import '@fortawesome/fontawesome-free/css/all.css'


Vue.prototype.$http = axios

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
library.add(fas)

Vue.config.productionTip = false

Vue.use(Vuex);
Vue.use(Vuelidate)


new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
