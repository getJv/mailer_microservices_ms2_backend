import Vue from "vue";
import Vuex from "vuex";
import sampleModule from "./modules/sample-module";


Vue.use(Vuex);


export default new Vuex.Store({
    modules: {
        sampleModule
    }
});
