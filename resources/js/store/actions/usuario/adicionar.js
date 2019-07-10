import api from '../../../api';
import router from '../../../router';

export default ({ dispatch, commit }, dados) => {
  commit('carregando', true);

  api.post('/api/usuarios', dados)
    .then(res => res.data)
    .then(token => {
      localStorage.setItem('token', JSON.stringify(token));
      router.push('/');
    })
    .catch(e => commit('exibirErros', e.response.data))
    .finally(() => commit('carregando', false));
}