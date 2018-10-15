import Vue from 'vue';
import store2 from 'store2';
import Buefy from 'buefy';
import ErrorPage from 'vue-error-page';
import { auth, config } from './util/mixins';
import Flash from './util/Flash';
import axios from 'axios';
import interceptors from './util/interceptors';


Vue.config.productionTip = false;

window.eventBus = new Vue();

window.storage = store2;
window.storage._.fn('pull', function (key) {
    return this.remove(key);
});

Vue.use(Buefy, {
    defaultToastDuration: 3000,
    defaultNoticeQueue: false,
    defaultTooltipType: 'is-info'
});

Vue.use(ErrorPage, {
    resolver: (component) => require(`./views/Errors/${component}`)
});

Vue.mixin(auth);
Vue.mixin(config);

Flash.setConfig({
    handler (message, type) {
        type = `is-${type}`;
        Vue.prototype.$toast.open({ message, type });
    }
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.request.use(...interceptors.request);
axios.interceptors.response.use(...interceptors.response);
Vue.prototype.$http = axios;







