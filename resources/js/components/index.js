import Vue from 'vue';

import EntrarForm from './Form/Entrar';
import CadastrarForm from './Form/Cadastrar';
import Field from "./Form/Comportamentais/Field";
import Button from "./Form/Comportamentais/Button";
import MarcaInput from "./Form/Comportamentais/Marca";
import Navbar from "./Layout/Navbar";
import Layout from "./Layout";
import Refrigerantes from './Refrigerantes/Lista';
import RefrigeranteForm from './Refrigerantes/Form';

Vue.component('field', Field);
Vue.component('ge-button', Button);
Vue.component('entrar-form', EntrarForm);
Vue.component('cadastrar-form', CadastrarForm);
Vue.component('navbar', Navbar);
Vue.component('layout', Layout);
Vue.component('refrigerantes', Refrigerantes);
Vue.component('refrigerante-form', RefrigeranteForm);
Vue.component('marca-input', MarcaInput);