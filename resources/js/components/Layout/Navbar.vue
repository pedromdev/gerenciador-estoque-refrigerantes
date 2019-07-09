<template>
  <div class="ui blue segment">
    <div class="ui blue secondary menu">

      <router-link to="/" class="item">Refrigerantes</router-link>

      <div class="right menu">
        <a class="item" v-on:click.prevent="deslogarUsuario">Sair</a>
      </div>

    </div>
  </div>
</template>

<script>
  import {mapActions} from 'vuex';

  export default {
    name: "Navbar",
    methods: {
      ...mapActions([
        'deslogarUsuario'
      ])
    }
  }
</script>