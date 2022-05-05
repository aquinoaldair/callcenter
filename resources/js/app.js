require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';

import { InertiaProgress } from '@inertiajs/progress';

InertiaProgress.init();

import VueCytoscape from 'vue-cytoscape';
Vue.use(VueCytoscape);

import VModal from 'vue-js-modal';
Vue.use(VModal);

import 'vue2-animate/dist/vue2-animate.min.css';

Vue.config.productionTip = true;


import { BootstrapVue } from "bootstrap-vue";
Vue.use(BootstrapVue);

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css';
Vue.use(VueGoodTablePlugin);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import Notifications from 'vue-notification';
Vue.use(Notifications);


Vue.use(plugin);

Vue.mixin({ methods: { route }});

//Intertia Render
const el = document.getElementById('app');
new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(el);
