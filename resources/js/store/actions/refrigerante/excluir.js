import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch, state }, id) => {
  commit('carregando', true);

  api.auth().refrigerantes.delete(`/${id}`)
    .then(() => {
      const { refrigerantes } = state;
      const index = refrigerantes.findIndex(refri => refri.id === id);

      if (index === -1) return;

      refrigerantes.splice(index, 1);

      commit('listarRefrigerantes', refrigerantes);
    })
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}