import VueRouter from "vue-router";

import EntrarPage from './pages/EntrarPage';
import CadastrarPage from './pages/CadastrarPage';

const routes = [
  {
    name: 'entrar',
    component: EntrarPage,
    path: '/entrar',
  },
  {
    name: 'cadastrar',
    component: CadastrarPage,
    path: '/cadastrar',
  },
  {
    path: '*',
    redirect: '/entrar'
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  const rotasDesbloqueadas = ['entrar', 'cadastrar'];

  if (!rotasDesbloqueadas.includes(to.name) && !localStorage.getItem('token')) {
    return router.push('/entrar');
  }

  next();
});

export default router;