import api from '../../../api';

export default ({ commit, state }, id) => {
  api.auth().refrigerantes.delete(`/${id}`)
    .then(() => {
      const { refrigerantes } = state;
      const index = refrigerantes.findIndex(refri => refri.id === id);

      if (index === -1) return;

      refrigerantes.splice(index, 1);

      commit('listarRefrigerantes', refrigerantes);
    })
    .catch(e => commit('exibirErros', e.response.data));
}