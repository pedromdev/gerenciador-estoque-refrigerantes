import VueRouter from "vue-router";

import EntrarPage from './pages/EntrarPage';
import CadastrarPage from './pages/CadastrarPage';
import Refrigerantes from './pages/Refrigerantes';

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
    name: 'refrigerantes',
    component: Refrigerantes,
    path: '/'
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
  } else if (rotasDesbloqueadas.includes(to.name) && localStorage.getItem('token')) {
    return router.push('/');
  }

  next();
});

export default router;