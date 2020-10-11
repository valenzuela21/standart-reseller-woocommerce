import Vue from 'vue'
import App from './App.vue'
import vuetify from '@/plugins/vuetify';

Vue.config.productionTip = false;

require('@/assets/bulma.css');
/* eslint-disable no-new */

new Vue({
    el: '#vue-frontend-app',
    vuetify,
    render: h => h(App)
})
