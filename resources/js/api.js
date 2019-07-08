import axios from 'axios';

axios.auth = () => {
  if (!localStorage.getItem('token')) return;

  const token = JSON.parse(localStorage.getItem('token'));

  const instance = axios.create({
    baseURL: '/api',
    headers: { Authorization: `Bearer ${token.access_token}` }
  });

  instance.autenticacao = axios.create({ baseURL: '/autenticacao' });
  instance.usuarios = axios.create({ baseURL: '/usuarios' });
  instance.marcas = axios.create({ baseURL: '/marcas' });
  instance.refrigerantes = axios.create({ baseURL: '/refrigerantes' });

  return instance;
};

export default axios;