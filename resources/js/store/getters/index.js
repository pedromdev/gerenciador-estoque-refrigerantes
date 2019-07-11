const getterPorCampo = campo => state => state[campo];

export default {
  carregando: getterPorCampo('carregando'),
  erros: state => ({
    tem(campo) {
      if (!campo) {
        return Object.keys(state.erros).filter(campo => state.erros[campo].length > 0).length > 0;
      }
      return !!state.erros[campo] && state.erros[campo].length > 0;
    },
    primeiro(campo) {
      return state.erros[campo].find(v => !!v);
    },
    todos(campo) {
      return state.erros[campo];
    }
  }),
  usuario: getterPorCampo('usuario'),
  marca: getterPorCampo('marca'),
  pegarMarca: id => state => state.marcas && state.marcas.find(marca => marca.id === id) || {},
  marcas: getterPorCampo('marcas'),
  refrigerante: getterPorCampo('refrigerante'),
  refrigerantes: getterPorCampo('refrigerantes'),
}

