<?php


namespace Tests\Utils;

use App\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\TestResponse;

trait LoginUsuario
{
    use MakesHttpRequests;

    /**
     * @var User
     */
    private $user;

    /**
     * @var TestResponse
     */
    private $login;

    /**
     * @var string
     */
    private $token;

    /**
     * Método para logar o usuário antes de cada teste.
     *
     * OBS: Não foi possível usar a anotação before por conta de erros (possivelmente por falta de inicialização)
     * nos helpers.
     */
    public function logarUsuarioDosTestes()
    {
        $email = 'email@example.com';
        $senha = '123456';
        $senhaEncriptada = bcrypt($senha);

        $this->user = factory(User::class)->create([ 'email' => $email, 'password' => $senhaEncriptada ]);
        $this->login = $this->logarUsuario($email, $senha);
        $this->token = $this->login->json('access_token');
    }

    /**
     * Retorna um token do usuário de acordo com o email e senha informados
     *
     * @param string $email
     * @param string $senha
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function logarUsuario($email, $senha)
    {
        return $this->post('/api/autenticacao/entrar', [
            'email' => $email,
            'password' => $senha
        ]);
    }
}