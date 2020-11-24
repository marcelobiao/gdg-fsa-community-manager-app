import axios from 'axios';

const api = axios.create({
    baseURL: process.env.REACT_APP_API_URL,
    /* headers: {
        'Access-Control-Allow-Origin': true,
      }, */
});

export default api;