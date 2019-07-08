require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VeeValidate, {Validator} from 'vee-validate';
import pt_BR from 'vee-validate/dist/locale/pt_BR';

import router from './router';
import App from './App';
import './components';
import store from './store';

Vue.use(VueRouter);
Vue.use(VeeValidate, {
  locale: "pt_BR"
});
Validator.localize("pt_BR", pt_BR);

const app = new Vue(
  Vue.util.extend({
    router,
    store
  }, App)
).$mount('#app');