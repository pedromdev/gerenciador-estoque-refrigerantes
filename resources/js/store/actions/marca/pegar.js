import api from '../../../api';

export default ({ commit }, id) => {
  api.auth().marcas.get(`/${id}`)
    .then(res => res.data)
    .then(marcas => commit('listarMarcas', marcas))
    .catch(e => commit('exibirErros', e.response.data));
}