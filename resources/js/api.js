import axios from 'axios';

axios.auth = () => {
  if (!localStorage.getItem('token')) return;

  const token = JSON.parse(localStorage.getItem('token'));

  const instance = axios.create({
    baseURL: '/api',
    headers: { Authorization: `Bearer ${token.access_token}` }
  });

  instance.autenticacao = axios.create({ baseURL: '/api/autenticacao' });
  instance.usuarios = axios.create({ baseURL: '/api/usuarios' });
  instance.marcas = axios.create({ baseURL: '/api/marcas' });
  instance.refrigerantes = axios.create({ baseURL: '/api/refrigerantes' });

  return instance;
};

export default axios;