import Vue from 'vue';
import Vuex, {Store} from 'vuex';
import getters from './getters';
import mutations from './mutations';
import * as actions from './actions';

Vue.use(Vuex);

export default new Store({
  state: {
    carregando: false,
    erros: {},
    usuario: {},
    marca: {},
    marcas: [],
    refrigerante: {},
    refrigerantes: [],
  },
  getters,
  mutations,
  actions
})
