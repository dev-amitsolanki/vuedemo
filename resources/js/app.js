require("./bootstrap");
import Router from "vue-router";
import VueRouter from "vue-router";
import router from "./router.js";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VeeValidate from "vee-validate";
import VueSession from 'vue-session';
import VModal from 'vue-js-modal';
import VueFlashMessage from 'vue-flash-message';
import Vuex from 'vuex'
import { store } from './store.js';

window.Vue = require("vue");

Vue.component("home", require("./components/home.vue"));

export const bus = new Vue()

axios.defaults.baseURL = 'http://127.0.0.1:8000/'
// axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`

Vue.use(Vuex)
Vue.use(VueFlashMessage)
Vue.use(VModal)
Vue.use(bus)
Vue.use(Router);
Vue.use(VueRouter);
Vue.use(axios, VueAxios);
Vue.use(VeeValidate);
Vue.use(VueSession)

Vue.prototype.$url = "http://127.0.0.1:8000/";

const app = new Vue({
    router,
    store,
    el: "#app"
});

