require('./semantic');

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

router.beforeEach((to, from, next) => {
  const rotasDesbloqueadas = ['entrar', 'cadastrar'];
  store.commit('exibirErros', {});

  if (!rotasDesbloqueadas.includes(to.name) && localStorage.getItem('token')) {
    store.dispatch('pegarUsuario');
  }

  next();
});

const app = new Vue(
  Vue.util.extend({
    router,
    store
  }, App)
).$mount('#app');