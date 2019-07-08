import api from '../../../api';

export default ({ commit, state }, dados) => {
  api.auth().refrigerantes.post('', dados)
    .then(res => res.data)
    .then(refrigerante => commit('listarRefrigerantes', [ ...state.refrigerantes, refrigerante ]))
    .catch(e => commit('exibirErros', e.response.data));
}