const getterPorCampo = campo => state => state[campo];

export default {
  erros: getterPorCampo('erros'),
  usuario: getterPorCampo('usuario'),
  marca: getterPorCampo('marca'),
  marcas: getterPorCampo('marcas'),
  refrigerante: getterPorCampo('refrigerante'),
  refrigerantes: getterPorCampo('refrigerantes'),
}