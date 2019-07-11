import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch }, id) => {
  commit('carregando', true);

  api.auth().refrigerantes.get(`/${id}`)
    .then(res => res.data)
    .then(refrigerantes => commit('listarRefrigerantes', refrigerantes))
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', true));
}