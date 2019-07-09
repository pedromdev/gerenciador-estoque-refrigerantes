import Vue from 'vue';

import EntrarForm from './Form/Entrar';
import CadastrarForm from './Form/Cadastrar';
import Field from "./Form/Utils/Field";

Vue.component('field', Field);
Vue.component('entrar-form', EntrarForm);
Vue.component('cadastrar-form', CadastrarForm);