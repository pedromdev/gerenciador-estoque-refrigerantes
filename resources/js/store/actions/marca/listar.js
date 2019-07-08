import api from '../../../api';

export default ({ commit }) => {
  api.auth().marcas.get('')
    .then(res => res.data)
    .then(marcas => commit('listarMarcas', marcas))
    .catch(e => commit('exibirErros', e.response.data));
}