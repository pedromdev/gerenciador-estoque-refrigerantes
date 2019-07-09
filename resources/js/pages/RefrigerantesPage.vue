<template>
  
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "RefrigerantesPage",
    mounted() {
      document.title = 'Lista de refrigerantes | Gerenciador de estoque';
      this.listarRefrigerantes();
    },
    methods: {
      ...mapActions([
        'listarRefrigerantes'
      ]),
    },
    computed: {
      ...mapGetters([
        'refrigerantes'
      ])
    }
  }
</script>