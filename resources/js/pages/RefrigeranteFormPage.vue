<template>
  <layout>

    <div class="ui refrigerantes">

      <div class="ui container main">
        <h1 class="ui header blue">{{ refrigerante.id ? 'Editar refrigerante' : 'Novo refrigerante'}}</h1>

        <refrigerante-form/>

      </div>

    </div>

  </layout>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "RefrigeranteFormPage",
    computed: {
      ...mapGetters([
        'refrigerante'
      ])
    }
  }
</script>