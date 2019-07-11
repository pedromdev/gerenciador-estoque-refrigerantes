import api from '../../../api';
import {tratarErroRequisao} from "../../helpers";

export default ({ commit, dispatch }) => {
  commit('carregando', true);

  api.auth().usuarios.get('/me')
    .then(res => res.data)
    .then(usuario => commit('pegarUsuario', usuario))
    .catch(tratarErroRequisao(commit, dispatch))
    .finally(() => commit('carregando', false));
}