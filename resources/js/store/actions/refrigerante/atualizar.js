import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch, state }, id, dados) => {
  commit('carregando', true);

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
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}