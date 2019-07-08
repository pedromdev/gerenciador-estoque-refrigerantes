import api from '../../../api';

export default ({ commit, state }, dados) => {
  api.auth().marcas.post('', dados)
    .then(res => res.data)
    .then(marca => commit('listarMarcas', [ ...state.marcas, marca ]))
    .catch(e => commit('exibirErros', e.response.data));
}