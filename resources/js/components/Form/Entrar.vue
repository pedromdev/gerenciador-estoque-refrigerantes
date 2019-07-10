<template>
  <form class="ui large form" v-bind:class="{ error: errors.has() || erros.tem() }" v-on:submit.prevent="onSubmit">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

        <field name="email" :errorsBag="errors">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input
              type="text"
              name="email"
              placeholder="E-mail"
              v-validate="'required|email'"
              data-vv-as="E-mail"
              v-model="credenciais.email"
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
              v-validate="'required'"
              data-vv-as="Senha"
              v-model="credenciais.password"
            >
          </div>
        </field>

        <button type="submit" class="ui fluid large blue submit button">Entrar</button>

        <p class="ui message small text center">
          Novo aqui? <router-link to="/cadastrar">Cadastre-se agora</router-link>
        </p>

      </div>
    </div>

  </form>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "EntrarForm",
    mounted() {
      console.log(this.carregando);
    },
    data() {
      return {
        credenciais: {
          email: '',
          password: '',
        }
      };
    },
    methods: {
      ...mapActions([ 'logarUsuario' ]),
      onSubmit() {
        this.$validator.validateAll().then(resultado => {
          if (!resultado) return;

          this.logarUsuario(this.credenciais);
        })
      }
    },
    computed: {
      ...mapGetters([ 'erros' ])
    }
  }
</script>
