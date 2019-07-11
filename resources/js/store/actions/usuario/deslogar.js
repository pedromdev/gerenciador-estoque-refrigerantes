import api from '../../../api';
import router from '../../../router';

function reiniciarEstado(commit) {
  localStorage.clear();
  commit('exibirErros', {});
  commit('pegarUsuario', {});
  commit('pegarMarca', {});
  commit('listarMarcas', []);
  commit('pegarRefrigerante', {});
  commit('listarRefrigerantes', []);
  router.push('/entrar');
}

export default ({ commit }) => {
  commit('carregando', true);

  api.auth().autenticacao.post('/sair')
    .then(() => reiniciarEstado(commit))
    .catch(e => {
      console.log(e);
      if (e.status === 401) {
        reiniciarEstado(commit)
      } else {
        commit('exibirErros', e.response.data)
      }
    })
    .finally(() => commit('carregando', false));
}