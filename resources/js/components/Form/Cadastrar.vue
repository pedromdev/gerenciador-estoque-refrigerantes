<template>
  <form class="ui large form" v-bind:class="{ error: erros.tem() || errors.has() }" v-on:submit.prevent="onSubmit">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

        <field name="name" :errorsBag="errors">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input
              type="text"
              name="name"
              placeholder="Nome"
              v-model="form.name"
              v-validate="'required|max:255'"
              data-vv-as="Nome"
            >
          </div>
        </field>

        <field name="email" :errorsBag="errors">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input
              type="text"
              name="email"
              placeholder="E-mail"
              v-model="form.email"
              v-validate="'required|email'"
              data-vv-as="E-mail"
            >
          </div>
        </field>

        <field name="password" :errorsBag="errors">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input
              type="password"
              name="password"
              placeholder="Senha"
              v-model="form.password"
              v-validate="'required|min:6|confirmed:password_confirmation'"
              data-vv-as="Senha"
            >
          </div>
        </field>

        <field name="password_confirmation" :errorsBag="errors">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input
              type="password"
              name="password_confirmation"
              placeholder="Confirmar senha"
              v-model="form.password_confirmation"
              v-validate="'required|min:6'"
              ref="password_confirmation"
              data-vv-as="Confirmar senha"
            >
          </div>
        </field>

        <button type="submit" class="ui fluid large blue submit button">Começar</button>

        <p class="ui message small text center">
          Já possui uma conta? <router-link to="/entrar">Faça o seu login</router-link>
        </p>

      </div>
    </div>

  </form>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

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
      ...mapActions([ 'adicionarUsuario' ]),
      onSubmit() {
        this.$validator.validateAll().then(resultado => {
          if (resultado) {
            this.adicionarUsuario(this.form);
          }
        });
      }
    },
    computed: {
      ...mapGetters([ 'erros' ]),
    }
  }
</script>
