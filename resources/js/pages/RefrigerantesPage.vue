<template>
  <layout></layout>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "RefrigerantesPage",
    titulo: 'Lista de refrigerantes',
    mounted() {
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