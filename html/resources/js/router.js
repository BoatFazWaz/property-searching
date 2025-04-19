import { createRouter, createWebHistory } from 'vue-router'
import PropertyList from './components/PropertyList.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: PropertyList
  },
  {
    path: '/:province',
    name: 'province',
    component: PropertyList
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('./components/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router 