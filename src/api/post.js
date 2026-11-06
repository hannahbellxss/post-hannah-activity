import api from './axios';

export const getPpost = () =>  {
    return api.get('/posts');
};

export const storePost = (data) => {
    return api.post('/posts', data);
};