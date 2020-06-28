import Vue from 'vue';
import Router from 'vue-router';

import HomePage from '../home/HomePage'
import LoginPage from '../login/LoginPage'
import RegisterPage from '../register/RegisterPage'
import ItemPage from '../item/ItemPage'
import ProfilePage from '../profile/ProfilePage'

Vue.use(Router);

export const router = new Router({
  mode: 'hash',
  routes: [
    { path: '/', component: HomePage },
    { path: '/item/:item_id', name: 'item', component: ItemPage, 
      props: (route) => ({ item_id: route.query.item_id })   
    },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
    { path: '/profile', name: 'profile', component: ProfilePage },

    // otherwise redirect to home
    { path: '*', redirect: '/' }
  ]
});

router.beforeEach((to, from, next) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const publicPages = ['/login', '/register'];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem('user');

  if (authRequired && !loggedIn) {
    return next('/login');
  }

  next();
})