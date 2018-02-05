import Vue from 'vue'
import Router from 'vue-router'
import MainLayout from '@/components/layouts/MainLayout'
import HelloWorld from '@/components/HelloWorld'
import Landing from '@/components/Landing'
import Login from '@/components/Login'
import Tasks from '@/components/Tasks'
import Counter from '@/components/CounterComponent'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/counter',
      name: 'Counter',
      component: Counter
    },
    {
      path: '/tasks',
      name: 'Tasks',
      component: Tasks
    },
    {
      path: '/',
      name: 'Landing',
      component: Landing
    },
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
          path: 'hello',
          alias: '',
          component: HelloWorld,
          name: 'Hello',
          meta: {
            description: 'Vue hello World',
            requiresAuth: true
          }
        },
        {
          path: 'tasks',
          name: 'Tasks',
          component: Tasks,
          meta: {
            description: 'Tasks',
            requiresAuth: true
          }
        }
      ]
    }
  ]
})
