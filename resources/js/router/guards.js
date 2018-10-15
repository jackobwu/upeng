import store from '../store';

export const auth = (to, from, next) => {
    if (store.getters.auth.guest) {
        window.storage.set('url.intended', to.fullPath);
        next('/signin');
    }

    next();
};

export const guest = (to, from, next) => {
    if (store.getters.auth.check) {
        next('/');
    }
    
    next();
};