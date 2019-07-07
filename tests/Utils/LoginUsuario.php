<?php


namespace Tests\Utils;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

trait LoginUsuario
{
    use MakesHttpRequests;

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