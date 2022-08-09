import Vuetify from "vuetify";

require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import routes from "./routes";
import $ from 'jquery';
import axios from 'axios';
import Vue2Filters from 'vue2-filters'

import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales-generated';
import VueSweetalert2 from 'vue-sweetalert2';
import Multiselect from 'vue-multiselect';

//youtube video
import VueYoutube from 'vue-youtube';

import App from './app.vue';

import Footer from "./components/layout/Footer";
import Header from "./components/layout/Header";
import Select2 from 'v-select2-component';
import Auth from './Auth.js';

Vue.prototype.auth = Auth;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueInternationalization);
Vue.use(VueSweetalert2);
Vue.use(Vue2Filters);

//youtube video
Vue.use(VueYoutube);


Vue.use('VueModalDialog');

window.axios = require('axios');


Vue.use(Vuetify);
var Paginate = require('vuejs-paginate');
Vue.component('paginate', Paginate);

Vue.component('select2', Select2);

Vue.component('multiselect', Multiselect);

if (window.__INITIAL_STATE__) {
    store.dispatch('storeSettingsModule/storeSettings')
}

const lang = document.documentElement.lang.substr(0, 2);
// or however you determine your current app locale
const i18n = new VueInternationalization({
    fallbackLocale: 'en',
    locale: lang,
    messages: Locale
});

// const app = new Vue({
//     el: '#app',
//     i18n,
//     components: { App,Footer, Header },
//     router: new VueRouter(routes),
// });
window.addEventListener("pageshow", () => {
    new Vue({
        el: "#app",
        i18n,
        components: { App,Footer, Header },
        router: new VueRouter(routes),
    });
});
