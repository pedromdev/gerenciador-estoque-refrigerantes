<template>
  <table class="ui blue unstackable table">
    <thead>
    <tr>
      <th>Marca</th>
      <th>Litragem</th>
      <th>Tipo</th>
      <th>Quantidade</th>
      <th>Valor</th>
      <th colspan="2">Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="refrigerante in refrigerantes">
      <td>{{ pegarMarca(refrigerante.marca_id).nome }}</td>
      <td>{{ refrigerante.litragem < 1 ? `${refrigerante.litragem * 1000} mL`: `${refrigerante.litragem} L`}}</td>
      <td>{{ refrigerante.tipo }}</td>
      <td>{{refrigerante.quantidade }}</td>
      <td>R$ {{ parseFloat(refrigerante.valor_unitario).toFixed(2) }}</td>
      <td>
        <router-link
          :to="{ name: 'editar-refrigerante', params: { id: refrigerante.id } }"
          class="ui icon circular green button"
          title="Editar refrigerante"
        >
          <i class="edit icon"></i>
        </router-link>
      </td>
      <td>
        <a
          href="#"
          class="ui icon circular red button"
          v-on:click.prevent="confirmarExcluisaoRefrigerante(refrigerante.id)">
          <i class="trash alternate icon"></i>
        </a>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "Refrigerantes",
    props: [ 'refrigerantes' ],
    methods: {
      ...mapActions([
        'excluirRefrigerante'
      ]),
      confirmarExcluisaoRefrigerante(id) {
        const resultado = confirm('Tem certeza que deseja excluir este refrigerante?');

        if (resultado) {
          this.excluirRefrigerante(id);
        }
      }
    },
    computed: {
      ...mapGetters([
        'pegarMarca'
      ])
    }
  }
</script>