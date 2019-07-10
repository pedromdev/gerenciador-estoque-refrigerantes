<template>
  <div class="main ui container fluid">
    <div class="ui centered grid no margin bottom no margin top">

      <div class="eight wide computer column computer only background image primary"></div>

      <div class="sixteen wide mobile eight wide computer column background very lighter gray full height">
        <div class="ui middle aligned center aligned grid full height">
          <div class="column">

            <h1 class="ui blue header">
              <div class="content">Cadastre-se</div>
            </h1>

            <p class="ui large ">Nunca foi tão fácil gerenciar o seu estoque! Preencha o formulário <br>abaixo e comece a usar.</p>

            <cadastrar-form></cadastrar-form>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  export default {
    name: "CadastrarPage",
    mounted() {
      document.title = 'Cadastrar | Gerenciador de estoque';
    }
  }
</script>