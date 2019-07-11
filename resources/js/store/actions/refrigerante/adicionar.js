import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";
import router from '../../../router';

export default ({ commit, dispatch, state }, dados) => {
  commit('carregando', true);

  api.auth().refrigerantes.post('', dados)
    .then(res => res.data)
    .then(refrigerante => {
      commit('listarRefrigerantes', [ ...state.refrigerantes, refrigerante ]);
      commit('pegarRefrigerante', refrigerante);
      router.push(`/refrigerantes/${refrigerante.id}`)
    })
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}