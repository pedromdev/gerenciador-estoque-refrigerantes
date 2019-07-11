# Gerenciador de estoque de refrigerantes
Sistema gerenciador de estoque de fornecedor de refrigerantes

Para iniciar a aplicação basta executar o comando a seguir:

```shell
$ docker-compose up
```

A primeira inicialização da aplicação irá instalar as dependências do projeto e fazer build dos arquivos públicos antes de iniciar o servidor, portanto, esta primeira inicialização pode demorar mais. As próximas iniciarão somente o servidor da aplicação.

## API
A API Rest possui dois grupos de rotas:
- Rotas públicas
- Rotas privadas

As rotas públicas podem ser acessadas sem qualquer autenticação prévia com a API. As rotas privadas precisam de uma autenticação prévia com a API, passando um token JWT retornado da mesma.

### Rotas públicas
#### POST /api/autenticacao/entrar
Essa rota é responsável por verificar se o e-mail e a senha informados são de algum usuário na aplicação e devolver um token JWT caso seja.

##### Exemplo de requisição:
```json
{
    "email": "pedro@mail.com",
    "password": "123456"
}
```

##### Exemplo de resposta:
```json
{
    "access_token": "<token-aqui>",
    "token_type": "bearer",
    "expires_in": 3600
}
```

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 422
```json
{
    "email": ["Este campo é obrigatório"],
    "password": ["Este campo é obrigatório"],
}
```
#### POST /usuarios
Essa rota é responsável por receber os dados de um novo usuário da aplicação e cadastrá-lo. Essa rota também retorna um token JWT de acesso do usuário cadastrado.

##### Exemplo de requisição:
```json
{
    "name": "Pedro Marcelo",
    "email": "pedro@mail.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

##### Exemplo de resposta:
```json
{
    "access_token": "<token-aqui>",
    "token_type": "bearer",
    "expires_in": 3600
}
```

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 422
```json
{
    "name": ["Este campo é obrigatório"],
    "email": ["Este campo é obrigatório"],
    "password": ["Este campo é obrigatório"],
    "password_confirmation": ["Este campo é obrigatório"]
}
```

### Rotas privadas
As rotas a seguir precisam de autenticação usando um token JWT retornado dos endpoints anteriores. A requisição deverá ter o token no cabeçalho HTTP Authorization, como no exemplo abaixo:
```http
Authorization: Bearer <token-aqui>
```

#### POST /api/autenticacao/atualizar
Essa rota é responsável por retornar um novo token JWT com tempo de expiração atualizado.

##### Exemplo de requisição:
A requisição não necessita de corpo

##### Exemplo de resposta:
```json
{
    "access_token": "<token-aqui>",
    "token_type": "bearer",
    "expires_in": 3600
}
```

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```

#### POST /api/autenticacao/sair
Essa rota é responsável por invalidar o token JWT do usuário

##### Exemplo de requisição:
A requisição não necessita de corpo

##### Exemplo de resposta:
A resposta não possui corpo

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```
##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```

#### GET /api/usuarios/me
Essa rota é responsável por retornar os dados do usuário atual

##### Exemplo de requisição:
A requisição não necessita de corpo

##### Exemplo de resposta:
```json
{
    "id": 1,
    "name": "Pedro",
    "email": "pedro@mail.com"
}
```

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```

#### PATCH /api/usuarios/me
Essa rota é responsável por atualizar os dados do usuário atual

##### Exemplo de requisição:
A requisição não necessita de corpo

##### Exemplo de resposta:
```json
{
    "id": 1,
    "name": "Pedro",
    "email": "pedro@mail.com"
}
```

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```
A aplicação retorna o seguinte JSON com o status 422
```json
{
    "name": ["O campo nome é maior que 255 caracteres"],
    "email": ["O campo e-mail não é um endereço válido"],
    "password": ["A senha tem menos que 6 caracteres"],
    "password_confirmation": ["A senha tem menos que 6 caracteres"]
}
```

#### DELETE /api/usuarios/me
Essa rota é responsável por excluir os dados do usuário atual

##### Exemplo de requisição:
A requisição não necessita de corpo

##### Exemplo de resposta:
A resposta não possui corpo

##### Exemplo de erro:
A aplicação retorna o seguinte JSON com o status 401
```json
{
    "message": "Não autorizado"
}
```
