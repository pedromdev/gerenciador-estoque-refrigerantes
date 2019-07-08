<template>
  <form class="ui large form" v-on:submit.prevent="onSubmit">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="name" placeholder="Nome" v-model="form.name">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input type="text" name="email" placeholder="E-mail" v-model="form.email">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Senha" v-model="form.password">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input
              type="password"
              name="password_confirmation"
              placeholder="Confirmar senha"
              v-model="form.password_confirmation">
          </div>
        </div>

        <button type="submit" class="ui fluid large blue submit button">Começar</button>

        <p class="ui message small text center">
          Já possui uma conta? <router-link to="/entrar">Faça o seu login</router-link>
        </p>

      </div>
    </div>

  </form>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "CadastrarForm",
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
        }
      };
    },
    methods: {
      ...mapGetters([ 'erros' ]),
      ...mapActions([ 'adicionarUsuario' ]),
      onSubmit() {
        this.adicionarUsuario(this.form);
      }
    }
  }
</script>
