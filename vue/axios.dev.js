import axios from 'axios';

const instance = axios.create({
  baseURL: 'https://box.dev/api',
  withCredentials: true,
});
export default instance;
