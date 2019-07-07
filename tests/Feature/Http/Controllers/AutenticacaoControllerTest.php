<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutenticacaoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFazerLoginDoUsuario()
    {
        $user = factory(User::class)->create([ 'password' => bcrypt('123456') ]);

        $response = $this->logarUsuario($user->email, '123456');

        $response->assertStatus(200);
        $response->assertJsonFragment([ 'token_type' => 'bearer' ]);
    }

    /**
     * @param string $email
     * @param string $senha
     * @dataProvider credendiaisInvalidas
     */
    public function testNaoFazerLoginDeUsuarioComCredenciaisInvalidas($email, $senha)
    {
        factory(User::class)->create([
            'email' => 'email@example.com',
            'password' => bcrypt('123456')
        ]);

        $response = $this->logarUsuario($email, $senha);

        $response->assertStatus(401);
    }

    public function testPegandoDadosDoUsuarioLogado()
    {
        $email = 'email@example.com';
        $senha = '123456';
        $user = factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $response = $this->logarUsuario($email, $senha);

        $response->assertStatus(200);
        $token = $response->json('access_token');

        $responseUsuario = $this->get('/api/autenticacao/me', [
            'Authentication' => "Bearer $token"
        ]);

        $responseUsuario->assertStatus(200);
        $responseUsuario->assertJsonFragment([
            'id' => $user->id,
            'email' => $email,
        ]);
    }

    public function testAtualizarTokenDeAutenticacao()
    {
        $email = 'email@example.com';
        $senha = '123456';
        factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $response = $this->logarUsuario($email, $senha);

        $response->assertStatus(200);
        $token = $response->json('access_token');

        $responseAtualizar = $this->post('/api/autenticacao/atualizar', [], [
            'Authentication' => "Bearer $token"
        ]);

        $responseAtualizar->assertStatus(200);
        $tokenAtualizado = $responseAtualizar->json('access_token');

        $this->assertNotEquals($token, $tokenAtualizado);
    }

    public function testDeslogarDaApi()
    {
        $email = 'email@example.com';
        $senha = '123456';
        factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $response = $this->logarUsuario($email, $senha);

        $response->assertStatus(200);
        $token = $response->json('access_token');

        $responseAtualizar = $this->post('/api/autenticacao/sair', [], [
            'Authentication' => "Bearer $token"
        ]);

        $responseAtualizar->assertStatus(204);
    }

    public function credendiaisInvalidas()
    {
        return [
            ['email2@example.com', '123456'],
            ['email@example.com', '654321'],
        ];
    }

    /**
     * @param $email
     * @param $senha
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function logarUsuario($email, $senha)
    {
        return $this->post('/api/autenticacao/entrar', [
            'email' => $email,
            'password' => $senha
        ]);
    }
}
