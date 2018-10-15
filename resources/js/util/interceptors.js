import axios from 'axios';
import Flash from './Flash';

const request = [
    (config) => {
        if (window.storage.has('auth.token')) {
            config.headers.common['Authorization'] = `Bearer ${window.storage.get('auth.token')}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
];

const response = [
    (response) => {
        const res = response;
        Flash.interceptor(res.data, 'success');
        return response;
    },
    (error) => {
        const res = error.response;
        Flash.interceptor(res.data, 'danger');
        
        if (res.data.message === 'jwt_refresh') {
            return axios.get('/api/refresh')
                .then(({ data: { token } }) => {
                    window.storage.set('auth.token', token);
                    res.config.headers['Authorization'] = `Bearer ${token}`;
                    return axios(res.config);
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        }

        return Promise.reject(error);
    }
];

export default { request, response };