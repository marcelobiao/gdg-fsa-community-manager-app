import axios from 'axios';
const access_token = localStorage.getItem('access_token');
const api = axios.create({
    baseURL: process.env.REACT_APP_API_URL,
    headers: {
        Authorization: 'bearer ' + access_token,
      },
});

export default api;