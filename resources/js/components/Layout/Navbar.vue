<template>
  <div class="ui blue grid centered">

    <div class="row">

      <div class="column sixteen wide no padding right">

        <div class="ui menu">

          <div class="ui main container">

            <router-link to="/" class="item">
              <h4 class="ui blue header">Gerenciador de estoque</h4>
            </router-link>

          </div>

        </div>

      </div>

      <div class="column sixteen wide mobile only no padding right">
        <div class="ui blue menu no margin bottom">

          <a class="launch icon item" @click.prevent="alternarMenu">
            <i class="content icon"></i>
          </a>

          <span class="item">Menu</span>

        </div>
      </div>

      <div class="column sixteen wide background white" :class="{ computer: menuAtivo, only: menuAtivo }">
        <div class="main ui container">

          <div class="ui blue secondary stackable menu">

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
  import {mapActions} from 'vuex';

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
      }
    }
  }
</script>