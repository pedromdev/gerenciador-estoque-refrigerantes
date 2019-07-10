import Vue from 'vue';

import EntrarForm from './Form/Entrar';
import CadastrarForm from './Form/Cadastrar';
import Field from "./Form/Comportamentais/Field";
import Button from "./Form/Comportamentais/Button";
import Navbar from "./Layout/Navbar";
import Layout from "./Layout";

Vue.component('field', Field);
Vue.component('ge-button', Button);
Vue.component('entrar-form', EntrarForm);
Vue.component('cadastrar-form', CadastrarForm);
Vue.component('navbar', Navbar);
Vue.component('layout', Layout);