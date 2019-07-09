import axios from 'axios';

axios.auth = () => {
  if (!localStorage.getItem('token')) return;

  const token = JSON.parse(localStorage.getItem('token'));

  const headers = { Authorization: `Bearer ${token.access_token}` };
  const instance = axios.create({ baseURL: '/api', headers });

  instance.autenticacao = axios.create({ baseURL: '/api/autenticacao', headers });
  instance.usuarios = axios.create({ baseURL: '/api/usuarios', headers });
  instance.marcas = axios.create({ baseURL: '/api/marcas', headers });
  instance.refrigerantes = axios.create({ baseURL: '/api/refrigerantes', headers });

  return instance;
};

export default axios;