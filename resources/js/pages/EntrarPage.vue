<template>
  <div class="main ui container">
    <div class="ui centered grid no margin bottom no margin top">

      <div class="sixteen wide mobile eight wide computer column background very lighter gray full height">
        <div class="ui middle aligned center aligned grid full height">
          <div class="column">

            <h1 class="ui blue header">
              <div class="content">Gerenciador de estoque</div>
            </h1>

            <p class="ui large ">Acesse agora a melhor plataforma de gerenciamento de <br>estoque do mercado</p>

            <entrar-form></entrar-form>

          </div>
        </div>
      </div>

      <div class="eight wide computer column computer only background image primary"></div>

    </div>
  </div>
</template>

<script>

  export default {
    name: "EntrarPage",

    mounted() {
      document.title = 'Entrar | Gerenciador de estoque';
    }
  }
</script>

<style>
  body {
    background-color: #dadada;
  }
</style>