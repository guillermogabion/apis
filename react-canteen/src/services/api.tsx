import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/v1/', // Replace with your API base URL
  withCredentials: true,
});

export default instance;