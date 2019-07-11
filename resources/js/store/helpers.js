export const tratarErroRequisao = (commit, dispatch) => e => {
  if (e.response.status === 401) {
    dispatch('deslogarUsuario');
  } else {
    commit('exibirErros', e.response.data);
  }
};