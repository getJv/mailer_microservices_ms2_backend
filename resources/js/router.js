import Vue from "vue";
import VueRouter from "vue-router";
import Page1 from "./views/Page1";
import Page2 from "./views/Page2";


Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [

        {
            path: "/",
            name: "page1",
            component: Page1,

        },
        {
            path: "/page2",
            name: "page2",
            component: Page2,

        },

    ]
});

