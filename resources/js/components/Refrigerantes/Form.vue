<template>
  <form class="ui large form" v-bind:class="{ error: erros.tem() || errors.has() }" v-on:submit.prevent="onSubmit">

    <div class="ui grid">

      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <field name="marca_id" :errorsBag="errors">
          <label for="marca_id">Marca:</label>
          <marca-input
            type="text"
            id="marca_id"
            name="marca_id"
            placeholder="Marca"
            v-model="form.marca_id"
            data-vv-as="Marca"
          />
        </field>
      </div>

      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <field name="litragem" :errorsBag="errors">
          <label for="litragem">Litragem:</label>
          <input
            type="number"
            id="litragem"
            name="litragem"
            placeholder="Litragem"
            step="0.01"
            min="0"
            max="5"
            v-model="form.litragem"
            v-validate="'required|min:0|max:5'"
            data-vv-as="Litragem"
          >
        </field>
      </div>

      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <field name="tipo" :errorsBag="errors">
          <label for="tipo">Tipo:</label>
          <select
            id="tipo"
            name="tipo"
            v-model="form.tipo"
            v-validate="'required|included:Pet,Garrafa,Lata'"
            data-vv-as="Tipo"
          >
            <option value="">Selecione um tipo...</option>
            <option value="Pet">Pet</option>
            <option value="Garrafa">Garrafa</option>
            <option value="Lata">Lata</option>
          </select>
        </field>
      </div>

      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <field name="quantidade" :errorsBag="errors">
          <label for="quantidade">Quantidade:</label>
          <input
            id="quantidade"
            type="number"
            name="quatidade"
            placeholder="Quantidade"
            step="1"
            min="0"
            v-model="form.quantidade"
            v-validate="'required|min:0'"
            data-vv-as="Quantidade"
          >
        </field>
      </div>

      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <field name="valor_unitario" :errorsBag="errors">
          <label for="litragem">Valor unitário:</label>
          <input
            type="number"
            id="valor_unitario"
            name="valor_unitario"
            placeholder="Valor unitário"
            step="0.01"
            min="0"
            v-model="form.valor_unitario"
            v-validate="'required|min:0'"
            data-vv-as="Valor unitário"
          >
        </field>
      </div>

      <div class="sixteen wide mobile eight wide tablet eight wide computer column"></div>

      <div class="sixteen wide mobile four wide tablet four wide computer column">
        <ge-button class="ui fluid large blue submit button">
          <i class="save icon"></i>
          Salvar
        </ge-button>
      </div>

      <div class="sixteen wide mobile four wide tablet four wide computer column">
        <router-link to="/" class="ui fluid large submit button">
          <i class="reply icon"></i>
          Voltar
        </router-link>
      </div>

    </div>

  </form>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';

  export default {
    name: "RefrigeranteForm",
    mounted() {
      if (this.$route.params.id) {
        this.pegarRefrigerante(this.$route.params.id);
      }
    },
    data() {
      return {
        form: {
          marca_id: null,
          litragem: '',
          tipo: '',
          quantidade: 0,
          valor_unitario: null,
        }
      };
    },
    methods: {
      ...mapActions([
        'pegarRefrigerante',
        'adicionarRefrigerante',
        'atualizarRefrigerante',
      ]),
      onSubmit() {
        if (this.refrigerante.id) {
          this.atualizarRefrigerante(this.refrigerante.id, this.form);
        } else {
          this.adicionarRefrigerante(this.form);
        }
      }
    },
    computed: {
      ...mapGetters([
        'refrigerante',
        'erros'
      ])
    },
    watch: {
      refrigerante(novoRefrigerante) {
        console.log(novoRefrigerante);
        this.form = novoRefrigerante;
      }
    }
  }
</script>