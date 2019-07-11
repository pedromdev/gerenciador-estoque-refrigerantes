<template>
  <div class="ui marcas">
    <input
      v-bind="$props"
      type="text"
      v-model="nome"
      v-on:keypress="onKeyPress"
      />
    <div v-if="nome.length > 0" class="ui marcas lista one column grid">
      <div v-if="marcasFiltradas.length > 0" v-for="marcaFiltrada in marcasFiltradas" class="column">
        <a href="#" v-on:click.prevent="onSelect(marcaFiltrada)">{{ marcaFiltrada.nome }}</a>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters, mapMutations} from 'vuex';

  export default {
    name: "Marca",
    props: ['value'],
    mounted() {
      if (this.marcas.length === 0) {
        this.listarMarcas();
      }
    },
    data() {
      return {
        nome: '',
        marcasFiltradas: [],
      }
    },
    methods: {
      ...mapActions([
        'listarMarcas',
        'adicionarMarca'
      ]),
      ...mapMutations([
        'pegarMarca'
      ]),
      onSelect(marcaSelecionada) {
        return (e) => {
          this.pegarMarca(marcaSelecionada);
        };
      },
      onBlur() {
        const marca = this.marcasFiltradas = this.marcas.find(marca => marca.id === this.$props.value);

        console.log(marca);

        if (!marca) return;

        this.pegarMarca(marca);
      },
      onKeyPress(e) {
        this.marcasFiltradas = this.marcas
          .filter(marca => marca.nome.toLowerCase().indexOf(this.nome.toLowerCase()) > -1);

        if ((e.keyCode === 13 || e.which === 13) && !!this.nome) {
          e.preventDefault();
          if (this.marcasFiltradas.length > 0) {
            this.pegarMarca(this.marcasFiltradas[0]);
          } else {
            this.adicionarMarca({
              nome: this.nome
            });
          }
        }
      }
    },
    computed: {
      ...mapGetters([
        'marcas',
        'marca'
      ])
    },
    watch: {
      marca(novaMarca) {
        this.$emit('input', novaMarca.id);
        this.nome = novaMarca.nome;
      }
    }
  }
</script>