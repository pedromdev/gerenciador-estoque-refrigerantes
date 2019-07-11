<template>
  <div class="ui stackable one column grid">

    <div class="row background white no padding bottom shadow">

      <div class="column sixteen wide no padding bottom cabecalho-menu" style="padding-bottom: 0!important;">

        <div class="ui ge menu secondary">

          <div class="ui main container">

            <router-link to="/" class="item no margin left">
              <h4 class="ui blue header">Gerenciador</h4>
            </router-link>

            <div class="right menu">
              <span class="item">Bem-vindo, {{ nomeUsuario() }}!</span>
            </div>

          </div>

        </div>

      </div>

      <div class="column sixteen wide mobile only no padding">
        <div class="ui blue ge menu no margin bottom">

          <a class="launch icon item" @click.prevent="alternarMenu">
            <i class="content icon"></i>
          </a>

          <span class="item">Menu</span>

        </div>
      </div>

      <div class="column sixteen wide background white" :class="{ tablet: menuAtivo, computer: menuAtivo, only: menuAtivo }">

        <div class="ui blue secondary ge stackable menu">

          <div class="main ui container">

            <router-link to="/" class="item">
              <i class="icon beer"></i> Refrigerantes
            </router-link>

            <div class="right menu">
              <a class="item" v-on:click.prevent="deslogarUsuario">
                <h5 class="ui red text thin">
                  <i class="icon sign-out no margin right"></i> Sair
                </h5>
              </a>
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "Navbar",
    data() {
      return {
        menuAtivo: true
      }
    },
    methods: {
      ...mapActions([
        'deslogarUsuario'
      ]),
      alternarMenu() {
        this.menuAtivo = !this.menuAtivo;
      },
      nomeUsuario() {
        if (!this.usuario || !this.usuario.name) return '';

        return this.usuario.name.split(' ')[0];
      }
    },
    computed: {
      ...mapGetters([
        'usuario'
      ])
    }
  }
</script>