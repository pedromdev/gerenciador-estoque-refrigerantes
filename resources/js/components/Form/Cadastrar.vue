<template>
  <form class="ui large form" v-bind:class="{ error: erros.tem() }" v-on:submit.prevent="onSubmit">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

        <div class="field" v-bind:class="{ error: erros.tem('name') || errors.has('name') }">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input
              v-validate="'required|max:255'"
              type="text"
              name="name"
              placeholder="Nome"
              v-model="form.name"
              data-vv-as="nome"
            >
          </div>

          <label v-if="erros.tem('name')">{{ erros.primeiro('name') }}</label>
          <label v-if="errors.has('name')">{{ errors.first('name') }}</label>
        </div>

        <div class="field" v-bind:class="{ error: erros.tem('email') || errors.has('email') }">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input
              v-validate="'required|email'"
              type="text"
              name="email"
              placeholder="E-mail"
              v-model="form.email"
              data-vv-as="e-mail"
            >
          </div>

          <label v-if="erros.tem('email')">{{ erros.primeiro('email') }}</label>
          <label v-if="errors.has('email')">{{ errors.first('email') }}</label>
        </div>

        <div class="field" v-bind:class="{ error: erros.tem('password') || errors.has('password') }">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input
              v-validate="'required|min:6|confirmed:password_confirmation'"
              type="password"
              name="password"
              placeholder="Senha"
              v-model="form.password"
              data-vv-as="senha"
            >
          </div>

          <label v-if="erros.tem('password')">{{ erros.primeiro('password') }}</label>
          <label v-if="errors.has('password')">{{ errors.first('password') }}</label>
        </div>

        <div
          class="field"
          v-bind:class="{ error: erros.tem('password_confirmation') || errors.has('password_confirmation') }"
        >
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input
              v-validate="'required|min:6'"
              type="password"
              name="password_confirmation"
              placeholder="Confirmar senha"
              v-model="form.password_confirmation"
              data-vv-as="confirmar senha"
              ref="password_confirmation"
            >
          </div>

          <label v-if="erros.tem('password_confirmation')">{{ erros.primeiro('password_confirmation') }}</label>
          <label v-if="errors.has('password_confirmation')">{{ errors.first('password_confirmation') }}</label>
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
      ...mapActions([ 'adicionarUsuario' ]),
      onSubmit() {
        this.$validator.validateAll().then(resultado => {
          if (!resultado) return;

          this.adicionarUsuario(this.form);
        });
      }
    },
    computed: {
      ...mapGetters([ 'erros' ]),
    }
  }
</script>
