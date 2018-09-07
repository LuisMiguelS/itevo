
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import vSelect from 'vue-select'
import VueNumeric from 'vue-numeric'
import Multiselect from 'vue-multiselect'
import VueCurrencyFilter from 'vue-currency-filter'

Vue.component('v-select', vSelect);
Vue.use(VueNumeric);
Vue.component('multiselect', Multiselect);

Vue.use(VueCurrencyFilter, {
    symbol : '$',
    thousandsSeparator: ',',
    fractionCount: 2,
    fractionSeparator: '.',
    symbolPosition: 'front',
    symbolSpacing: true
});

Vue.component('inscription', require('./components/Inscription'));
Vue.component('accounts-receivable', require('./components/Accounts_Receivable'));

const app = new Vue({
    el: '#app'
});