import { createRouter, createWebHistory } from 'vue-router'
import PropertyList from './components/PropertyList.vue'
import TestComponent from './components/TestComponent.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: PropertyList
  },
  {
    path: '/test',
    name: 'test',
    component: TestComponent
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