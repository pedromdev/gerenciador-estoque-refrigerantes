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
