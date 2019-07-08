import Vue from 'vue';
import Vuex, {Store} from 'vuex';
import getters from './getters';
import mutations from './mutations';
import * as actions from './actions';

Vue.use(Vuex);

export default new Store({
  state: {
    erros: {},
    usuario: null,
    marca: null,
    marcas: [],
    refrigerante: null,
    refrigerantes: [],
  },
  getters,
  mutations,
  actions
})
