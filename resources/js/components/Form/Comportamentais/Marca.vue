<template>
  <div class="ui marcas">
    <input
      v-bind="$props"
      type="text"
      v-model="nome"
      v-on:keypress="onKeyPress"
      v-on:keyup="onKeyUp"
      v-on:blur="onBlur"
      />
    <div v-if="nome.length > 0 && estaDigitando" class="ui marcas lista overflow scroll y">
      <a
        href="#"
        v-if="marcasFiltradas.length > 0"
        v-for="marcaFiltrada of marcasFiltradas"
        v-on:click.prevent="onSelect(marcaFiltrada)"
      >
        {{ marcaFiltrada.nome }}
      </a>
      <a
        href="#"
        v-if="marcasFiltradas.length === 0"
        v-on:click.prevent="onSelect(marcaFiltrada)"
        class="text grey"
      >
        Pressione Enter ou clique aqui para adicionar esta marca...
      </a>
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
        estaDigitando: false,
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
        this.pegarMarca(marcaSelecionada);
      },
      onBlur() {
        const marca = this.marcas.find(marca => marca.id === this.$props.value);

        if (!marca) return;

        this.pegarMarca(marca);
      },
      filtrarPorNome() {
        this.marcasFiltradas = this.marcas.filter(marca => (
          marca.nome.toLowerCase().indexOf(this.nome.toLowerCase()) > -1
        ));
      },
      onKeyUp(e) {
        this.estaDigitando = true;
        this.filtrarPorNome();

        if (!this.nome) {
          this.estaDigitando = false;
          this.$emit('input', null);
        }
      },
      onKeyPress(e) {
        this.estaDigitando = true;
        this.filtrarPorNome();

        if ((e.keyCode === 13 || e.which === 13) && !!this.nome) {
          e.preventDefault();

          if (this.marcasFiltradas.length > 0) {
            this.pegarMarca({
              ...this.marcasFiltradas[0]
            });
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
        'refrigerante',
        'marcas',
        'marca'
      ])
    },
    watch: {
      refrigerante(novoRefrigerante) {
        if (!this.marcas.length) return;

        const marca = this.marcas.find(marca => marca.id === novoRefrigerante.marca_id);

        this.pegarMarca({ ...marca });
      },
      marca(novaMarca) {
        this.$emit('input', novaMarca.id);
        this.nome = novaMarca.nome;
        this.estaDigitando = false;
        this.marcasFiltradas = [];
      },
      marcas(novasMarcas) {
        if (!this.refrigerante.id) return;

        const marca = novasMarcas.find(marca => marca.id === this.refrigerante.marca_id);

        this.pegarMarca({ ...marca });
      }
    }
  }
</script>