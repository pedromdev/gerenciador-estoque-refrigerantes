<?php

namespace Tests\Feature\Http\Controllers;

use App\Marca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Utils\LoginUsuario;

class MarcaControllerTest extends TestCase
{

    use RefreshDatabase, LoginUsuario;

    /**
     * @after
     */
    public function limparUsuario()
    {
        $this->user = null;
        $this->login = null;
        $this->token = null;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCadastrarMarcaDeRefrigerante()
    {
        $nome = 'Coca-Cola';

        $this->logarUsuarioDosTestes();

        $response = $this->post('/api/marcas', [ 'nome' => $nome ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'nome' => $nome,
                'slug' => Str::slug($nome)
            ]);
    }

    /**
     * @param array $dados
     * @dataProvider dadosInvalidos
     */
    public function testNaoCadastraAMarcaComDadosInvalidos(array $dados)
    {
        $this->logarUsuarioDosTestes();
        factory(Marca::class)->create([
            'nome' => 'Coca-Cola',
            'slug' => 'coca-cola',
            'user_id' => $this->user->id,
        ]);

        $response = $this->post('/api/marcas', $dados, [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422);
    }

    public function testListarMarcasDoUsuario()
    {
        $this->logarUsuarioDosTestes();
        factory(Marca::class)->create([
            'nome' => 'Coca-Cola',
            'slug' => 'coca-cola',
            'user_id' => $this->user->id,
        ]);
        factory(Marca::class)->create([
            'nome' => 'Fanta',
            'slug' => 'fanta',
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/api/marcas', [ 'Authorization' => "Bearer {$this->token}" ]);
        $json = $response->json();

        $response->assertStatus(200);
        $this->assertEquals(2, count($json));
    }

    public function dadosInvalidos()
    {
        return [
            [
                []
            ],
            [
                [ 'nome' => Str::random(31) ]
            ],
            [
                [ 'nome' => 'Coca-Cola' ]
            ],
        ];
    }
}
