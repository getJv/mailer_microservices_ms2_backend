import Vue from 'vue'
import App from './views/app.vue'
import router from "./router";
import store from "./store";
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify({}),
    components: { App },

});
