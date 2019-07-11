import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch }, id) => {
  commit('carregando', true);

  api.auth().marcas.get(`/${id}`)
    .then(res => res.data)
    .then(marcas => commit('listarMarcas', marcas))
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}