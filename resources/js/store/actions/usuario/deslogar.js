import api from '../../../api';
import router from '../../../router';

export default ({ commit }) => {
  commit('carregando', true);

  api.auth().autenticacao.post('/sair').then(() => {
    localStorage.clear();
    commit('exibirErros', {});
    commit('pegarUsuario', null);
    commit('pegarMarca', null);
    commit('listarMarcas', []);
    commit('pegarRefrigerante', null);
    commit('listarRefrigerantes', []);
    router.push('/entrar');
  }).catch(e => commit('exibirErros', e.response.data))
    .finally(() => commit('carregando', false));
}