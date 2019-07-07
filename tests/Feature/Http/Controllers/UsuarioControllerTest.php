<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Utils\LoginUsuario;

class UsuarioControllerTest extends TestCase
{

    use RefreshDatabase, LoginUsuario;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPegandoDadosDoUsuarioLogado()
    {
        $email = 'email@example.com';
        $senha = '123456';
        $user = factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $login = $this->logarUsuario($email, $senha);

        $login->assertStatus(200);
        $token = $login->json('access_token');

        $responseUsuario = $this->get('/api/usuarios/me', [
            'Authentication' => "Bearer $token"
        ]);

        $responseUsuario->assertStatus(200);
        $responseUsuario->assertJsonFragment([
            'id' => $user->id,
            'email' => $email,
        ]);
    }

    public function testCadastrandoUmNovoUsuarioNoSistemaERetornandoOToken()
    {
        $dados = [
            'name' => 'Pedro Marcelo',
            'email' => 'pedro@email.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $cadastro = $this->post('/api/usuarios', $dados);

        $cadastro->assertStatus(201)
            ->assertJsonFragment([ 'token_type' => 'bearer' ]);
    }

    /**
     * @param array $dados
     * @dataProvider dadosInvalidos
     */
    public function testNaoCadastrarUsuarioComDadosInvalidos(array $dados)
    {
        factory(User::class)->create([ 'email' => 'pedro@email.com' ]);

        $cadastro = $this->post('/api/usuarios', $dados);

        $cadastro->assertStatus(422);
    }

    public function testAtualizarDadosDoUsuario()
    {
        $nome = 'Pedro Marcelo';
        $email = 'email@example.com';
        $novoEmail = 'email2@example.com';
        $senha = '123456';
        factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $login = $this->logarUsuario($email, $senha);

        $login->assertStatus(200);
        $token = $login->json('access_token');

        $atualizacao = $this->patch('/api/usuarios/me', [
            'name' => $nome,
            'email' => $novoEmail,
            'password' => '654321',
            'password_confirmation' => '654321',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $atualizacao->assertStatus(200)
            ->assertJsonFragment([ 'name' => $nome, 'email' => $novoEmail ]);
    }

    /**
     * @param array $dados
     * @dataProvider dadosInvalidosSemOsCamposObrigatorios
     */
    public function testNaoAtualizaOsDadosDoUsuarioComDadosInvalidos(array $dados)
    {
        $email = 'pedro@email.com';
        $email2 = 'pedro2@email.com';
        $senha = '123456';
        factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);
        factory(User::class)->create([ 'email' => $email2, 'password' => bcrypt($senha) ]);

        $login = $this->logarUsuario($email2, $senha);

        $login->assertStatus(200);
        $token = $login->json('access_token');

        $atualizacao = $this->patch('/api/usuarios/me', $dados, [
            'Authorization' => "Bearer $token"
        ]);

        $atualizacao->assertStatus(422);
    }

    public function testExcluirUmUsuario()
    {
        $email = 'pedro@email.com';
        $senha = '123456';
        factory(User::class)->create([ 'email' => $email, 'password' => bcrypt($senha) ]);

        $login = $this->logarUsuario($email, $senha);

        $login->assertStatus(200);
        $token = $login->json('access_token');

        $exclusao = $this->delete('/api/usuarios/me', [], [
            'Authorization' => "Bearer $token"
        ]);

        $exclusao->assertStatus(204);

        $users = User::where('email', $email)->get();

        $this->assertEquals(0, count($users));
    }

    public function dadosInvalidos()
    {
        return [
            // Nome faltando
            [
                [
                    'email' => 'pedro2@email.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                ]
            ],
            // E-mail faltando
            [
                [
                    'name' => 'Pedro Marcelo',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                ]
            ],
            // Senha faltando
            [
                [
                    'name' => 'Pedro Marcelo',
                    'email' => 'pedro2@email.com',
                ]
            ],
            // Nome maior do que o permitido
            [
                [
                    'name' => Str::random(256),
                    'email' => 'pedro2@email.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                ]
            ],
            // E-mail já existente
            [
                [
                    'name' => 'Pedro Marcelo',
                    'email' => 'pedro@email.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                ]
            ],
            // Senha menor do que o permitido
            [
                [
                    'name' => 'Pedro Marcelo',
                    'email' => 'pedro2@email.com',
                    'password' => '12345',
                    'password_confirmation' => '12345',
                ]
            ],
            // Senhas não batem
            [
                [
                    'name' => 'Pedro Marcelo',
                    'email' => 'pedro2@email.com',
                    'password' => '123456',
                    'password_confirmation' => '12345',
                ]
            ],
        ];
    }

    public function dadosInvalidosSemOsCamposObrigatorios()
    {
        return array_slice($this->dadosInvalidos(), 3);
    }
}
