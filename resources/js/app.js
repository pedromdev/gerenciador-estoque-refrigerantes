require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

import routes from './routes'
import App from './App'

Vue.use(VueRouter);

const app = new Vue(
  Vue.util.extend({
      router: new VueRouter({
          mode: 'history',
          routes
      })
  }, App)
).$mount('#app');