import'./bootstrap';
import Vue from 'vue';
import App from './components/App';
import store from './store';
import router from './router';


store.dispatch('fetchAuthUser').then(() => {
    new Vue({
        router,
        store,
        render: (h) => h(App)
    }).$mount('#app');
});
