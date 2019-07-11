import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch, state }, dados) => {
  commit('carregando', true);

  api.auth().marcas.post('', dados)
    .then(res => res.data)
    .then(marca => {
      commit('listarMarcas', [ ...state.marcas, marca ]);
      commit('pegarMarca', marca);
    })
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}