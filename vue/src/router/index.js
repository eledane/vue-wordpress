import Vue from 'vue'
import Router from 'vue-router'
import Hello from '@/components/Hello'
import Elyzium from '@/components/Elyzium'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/hello',
      name: 'Hello',
      component: Hello
    },
    {
      path: '/',
      name: 'Elyzium',
      component: Elyzium
    }
  ]
})
