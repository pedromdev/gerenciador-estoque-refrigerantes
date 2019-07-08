import api from '../../../api';

export default ({ commit, state }, id, dados) => {
  api.auth().refrigerantes.post(`/${id}`, dados)
    .then(res => res.data)
    .then(refrigerante => {
      const { refrigerantes } = state;
      const index = refrigerantes.findIndex(refri => refri.id === id);

      commit('pegarRefrigerante', refrigerante);

      if (index === -1) return;

      refrigerantes.splice(index, 1, refrigerante);

      commit('listarRefrigerantes', refrigerantes);
    })
    .catch(e => commit('exibirErros', e.response.data));
}