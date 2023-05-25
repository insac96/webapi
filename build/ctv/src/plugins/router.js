import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "route" */ '@/layouts/AdminLayout.vue'),
  },

  { path: '*', redirect: { path: '/' } }
]

const router = new VueRouter({
  mode: 'history',
  base: '/',
  routes
})

export default router
