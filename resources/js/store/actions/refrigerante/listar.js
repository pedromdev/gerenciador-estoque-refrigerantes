import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch }) => {
  commit('carregando', true);

  api.auth().refrigerantes.get('')
    .then(res => res.data)
    .then(refrigerantes => commit('listarRefrigerantes', refrigerantes))
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}