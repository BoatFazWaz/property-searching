import { createRouter, createWebHistory } from 'vue-router'
import PropertyList from './components/PropertyList.vue'
import PlaceholderPage from './components/PlaceholderPage.vue'
import AboutPage from './components/AboutPage.vue'
import ContactPage from './components/ContactPage.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: PropertyList
  },
  {
    path: '/properties',
    name: 'properties',
    component: PropertyList
  },
  {
    path: '/about',
    name: 'about',
    component: AboutPage
  },
  {
    path: '/contact',
    name: 'contact',
    component: ContactPage
  },
  {
    path: '/locations',
    name: 'locations',
    component: PlaceholderPage,
    props: { title: 'Locations' }
  },
  {
    path: '/investments',
    name: 'investments',
    component: PlaceholderPage,
    props: { title: 'Investment Opportunities' }
  },
  {
    path: '/new-developments',
    name: 'new-developments',
    component: PlaceholderPage,
    props: { title: 'New Developments' }
  },
  {
    path: '/team',
    name: 'team',
    component: PlaceholderPage,
    props: { title: 'Our Team' }
  },
  {
    path: '/careers',
    name: 'careers',
    component: PlaceholderPage,
    props: { title: 'Careers' }
  },
  {
    path: '/testimonials',
    name: 'testimonials',
    component: PlaceholderPage,
    props: { title: 'Client Testimonials' }
  },
  {
    path: '/privacy',
    name: 'privacy',
    component: PlaceholderPage,
    props: { title: 'Privacy Policy' }
  },
  {
    path: '/terms',
    name: 'terms',
    component: PlaceholderPage,
    props: { title: 'Terms of Service' }
  },
  {
    path: '/cookies',
    name: 'cookies',
    component: PlaceholderPage,
    props: { title: 'Cookie Policy' }
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