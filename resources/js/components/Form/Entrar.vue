<template>
  <form class="ui large form">

    <div class="ui centered grid">
      <div class="sixteen wide mobile ten wide computer column">

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

        <button type="submit" class="ui fluid large blue submit button">Entrar</button>

        <p class="ui message small text center">
          Novo aqui? <router-link to="/cadastrar">Cadastre-se agora</router-link>
        </p>

      </div>
    </div>

  </form>
</template>

<script>
  export default {
    name: "EntrarForm"
  }
</script>
