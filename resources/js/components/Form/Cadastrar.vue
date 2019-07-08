<template>
  <form class="ui large form">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="name" placeholder="Nome">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input type="text" name="email" placeholder="E-mail">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Senha">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password_confirmation" placeholder="Confirmar senha">
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
  export default {
    name: "CadastrarForm"
  }
</script>
