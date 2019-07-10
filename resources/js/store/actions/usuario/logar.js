import api from '../../../api';
import router from '../../../router';

export default ({ dispatch, commit }, credenciais) => {
  commit('carregando', true);

  api.post('/api/autenticacao/entrar', credenciais)
    .then(res => res.data)
    .then(token => {
      localStorage.setItem('token', JSON.stringify(token));
      router.push('/');
    }).catch(e => {
      if (e.response.status === 401) {
        commit('exibirErros', {
          email: [ 'E-mail e/ou senha incorretos' ]
        })
      } else {
        commit('exibirErros', e.response.data)
      }
    })
    .finally(() => commit('carregando', false));
}