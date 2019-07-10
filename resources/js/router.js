import VueRouter from "vue-router";

import EntrarPage from './pages/EntrarPage';
import CadastrarPage from './pages/CadastrarPage';
import RefrigerantesPage from './pages/RefrigerantesPage';

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
    component: RefrigerantesPage,
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
  const titulos = ['Gerenciador de estoque'];

  if (!rotasDesbloqueadas.includes(to.name) && !localStorage.getItem('token')) {
    return router.push('/entrar');
  } else if (rotasDesbloqueadas.includes(to.name) && localStorage.getItem('token')) {
    return router.push('/');
  }

  const titulosPagina = to.matched
    .map(route => Object.values(route.components))
    .reduce((componentes, c) => componentes.concat(c), [])
    .filter(componente => !!componente.titulo)
    .map(componente => componente.titulo);

  document.title = titulosPagina.concat(titulos).join(' | ');

  next();
});

export default router;