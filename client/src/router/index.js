import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import CreateView from '../views/CreateView.vue'
import ListView from '../views/ListView.vue'
import ShowView from '../views/ShowView.vue'
import RegisterView from '../views/RegisterView.vue'
import Guard from '../services/middleware'

Vue.use(VueRouter)

const routes = [
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
  },
  {
    path: '/show/:id',
    name: 'show',
    component: ShowView,
    beforeEnter: Guard.auth,
  },
  {
    path: '/list',
    name: 'list',
    component: ListView,
    beforeEnter: Guard.auth,
  },
  {
    path: '/create',
    name: 'create',
    component: CreateView,
    beforeEnter: Guard.auth,
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/',
    name: 'home',
    component: HomeView,
    beforeEnter: Guard.auth,
  },
  {
    path: '/about',
    name: 'about',
    beforeEnter: Guard.auth,
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
