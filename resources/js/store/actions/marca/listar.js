import api from '../../../api';

export default ({ commit }) => {
  commit('carregando', true);

  api.auth().marcas.get('')
    .then(res => res.data)
    .then(marcas => commit('listarMarcas', marcas))
    .catch(e => commit('exibirErros', e.response.data))
    .finally(() => commit('carregando', false));
}