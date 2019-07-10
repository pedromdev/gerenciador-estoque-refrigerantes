const mutationPorCampo = campo => (state, valor) => state[campo] = valor;

export default {
  carregando: mutationPorCampo('carregando'),
  exibirErros: mutationPorCampo('erros'),
  pegarUsuario: mutationPorCampo('usuario'),
  pegarMarca: mutationPorCampo('marca'),
  listarMarcas: mutationPorCampo('marcas'),
  pegarRefrigerante: mutationPorCampo('refrigerante'),
  listarRefrigerantes: mutationPorCampo('refrigerantes'),
}