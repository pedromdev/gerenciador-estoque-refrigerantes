import api from '../../../api';

export default ({ commit }) => {
  api.auth().usuarios.get('/me')
    .then(res => res.data)
    .then(usuario => commit('pegarUsuario', usuario))
    .catch(e => commit('exibirErros', e.response.data));
}