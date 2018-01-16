import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Example from '@/components/Example'
import Login from '@/components/Login'
import MainLayout from '@/components/layouts/MainLayout'

Vue.use(Router)

let router = new Router({
  // mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/',
      name: 'MainLayout',
      component: MainLayout,
      children: [
        {
          path: '/hello',
          alias: '',
          component: HelloWorld,
          name: 'Hello',
          meta: {
            description: 'Vue hello World'
          }
        },
        {
          path: '/example',
          name: 'Example',
          component: Example,
          meta: {
            description: 'Super exemple'
          }
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && (!router.app.$store.state.token || router.app.$store.state.token === 'null')) {
    window.console.log('Not authenticated')
    next({
      path: '/login',
      query: {redirect: to.fullPath}
    })
  } else {
    next()
  }
})

export default router
