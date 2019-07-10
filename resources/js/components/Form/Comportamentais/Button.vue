<template>
  <button
    v-bind="$props"
    :class="{loading: carregando}"
    :disabled="carregando"
  >
    <slot/>
  </button>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "Button",
    computed: {
      ...mapGetters([ 'carregando' ])
    }
  }
</script>