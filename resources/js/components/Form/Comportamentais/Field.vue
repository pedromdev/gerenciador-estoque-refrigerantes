<template>
  <div class="field" v-bind:class="{ error: erros.tem(name) || errorsBag.has(name) }">
    <slot></slot>
    <label v-if="erros.tem(name)">{{ erros.primeiro(name) }}</label>
    <label v-if="errorsBag.has(name)">{{ errorsBag.first(name) }}</label>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "Field",
    props: [ 'name', 'errorsBag' ],
    computed: {
      ...mapGetters([ 'erros' ]),
    }
  }
</script>