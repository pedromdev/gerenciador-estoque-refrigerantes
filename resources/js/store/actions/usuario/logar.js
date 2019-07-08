import api from '../../../api';

export default ({ dispatch, commit }, credenciais) => {
  api.post('/autenticacao/entrar', credenciais)
    .then(res => res.data)
    .then(token => {
      localStorage.setItem('token', JSON.stringify(token));
      dispatch('pegarUsuario');
    }).catch(e => commit('exibirErros', e.response.data));
}