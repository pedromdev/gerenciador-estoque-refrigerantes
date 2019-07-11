import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch }) => {
  commit('carregando', true);

  api.auth().marcas.get('')
    .then(res => res.data)
    .then(marcas => commit('listarMarcas', marcas))
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}