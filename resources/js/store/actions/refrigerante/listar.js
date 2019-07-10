import api from '../../../api';

export default ({ commit }) => {
  commit('carregando', true);

  api.auth().refrigerantes.get('')
    .then(res => res.data)
    .then(refrigerantes => commit('listarRefrigerantes', refrigerantes))
    .catch(e => commit('exibirErros', e.response.data))
    .finally(() => commit('carregando', false));
}