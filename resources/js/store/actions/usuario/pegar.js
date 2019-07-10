import api from '../../../api';

export default ({ commit }) => {
  commit('carregando', true);

  api.auth().usuarios.get('/me')
    .then(res => res.data)
    .then(usuario => commit('pegarUsuario', usuario))
    .catch(e => commit('exibirErros', e.response.data))
    .finally(() => commit('carregando', false));
}