import api from '../../../api';

export default ({ commit }, id) => {
  api.auth().refrigerantes.get(`/${id}`)
    .then(res => res.data)
    .then(refrigerantes => commit('listarRefrigerantes', refrigerantes))
    .catch(e => commit('exibirErros', e.response.data));
}