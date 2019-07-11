<template>
  <layout>
    <div class="ui refrigerantes">
      <div class="ui main container" :class="{'overflow scroll x': refrigerantes.length > 1}">
        <h1 class="ui blue header">Refrigerantes</h1>
        <refrigerantes v-if="refrigerantes.length > 0" :refrigerantes="refrigerantes" />

        <div v-if="refrigerantes.length === 0" class="ui grid middle aligned center aligned center" style="height: 60vh">
          <div class="column">
            <h2 class="ui header light grey">
              Nenhum refrigerante cadastrado no momento.
              Clique em <i class="plus circle icon no margin right"></i> para adicionar um novo refrigerante.
            </h2>
          </div>
        </div>

      </div>
      <router-link
        to="/refrigerantes/novo"
        class="ui icon circular floating blue huge button"
        title="Adicionar refrigerante"
      >
        <i class="icon plus"></i>
      </router-link>
    </div>
  </layout>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "RefrigerantesPage",
    titulo: 'Lista de refrigerantes',
    mounted() {
      if (this.refrigerantes.length === 0) this.listarRefrigerantes();
      if (this.marcas.length === 0) this.listarMarcas();
    },
    methods: {
      ...mapActions([
        'listarRefrigerantes',
        'listarMarcas'
      ]),
    },
    computed: {
      ...mapGetters([
        'refrigerantes',
        'marcas',
      ])
    }
  }
</script>