<?php

namespace Tests\Feature\Http\Controllers;

use App\Marca;
use App\Refrigerante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utils\LoginUsuario;

class RefrigeranteControllerTest extends TestCase
{

    use RefreshDatabase, LoginUsuario;

    /**
     * @var Marca
     */
    private $marca;

    /**
     * Método utilizado para criar uma marca de refrigerante para ser usada nos testes
     *
     * @return Marca
     */
    public function criarMarcaDosTestes()
    {
        $this->logarUsuarioDosTestes();
        $marca = factory(Marca::class)->create([
            'nome' => 'Marca',
            'slug' => 'marca',
            'user_id' => $this->user->id
        ]);

        $this->marca = $marca;
        return $marca;
    }

    /**
     * @after
     */
    public function limparMarca()
    {
        $this->marca = null;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCadastrarRefrigeranteNoEstoque()
    {
        $this->criarMarcaDosTestes();
        $dados = [
            'marca_id' => $this->marca->id,
            'litragem' => 2.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 7.5,
        ];

        $response = $this->post('/api/refrigerantes', $dados, [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment($dados);
    }

    /**
     * @param array $dados
     * @dataProvider dadosInvalidos
     */
    public function testNaoCadastraORefrigeranteComDadosInvalidos(array $dados)
    {
        $this->criarMarcaDosTestes();
        factory(Refrigerante::class)->create([
            'marca_id' => $this->marca->id,
            'litragem' => 3.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 7.5,
        ]);

        $response = $this->post('/api/refrigerantes', $dados, [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422);
    }

    /**
     * @param string $metodo
     * @dataProvider metodosHttpDeAtualizar
     */
    public function testAtualizarUmRefrigerante($metodo)
    {
        $this->criarMarcaDosTestes();
        $dados = [
            'marca_id' => $this->marca->id,
            'litragem' => 3.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 7.5,
        ];
        $refrigerante = factory(Refrigerante::class)->create($dados);

        $response = $this->{$metodo}("/api/refrigerantes/{$refrigerante->id}", array_merge($dados, [
            'quantidade' => 50
        ]), [ 'Authorization' => "Bearer {$this->token}"]);

        $response->assertStatus(200)
            ->assertJsonFragment([ 'quantidade' => 50 ]);
    }

    public function testPegarRefrigeranteDoEstoqueDoUsuario()
    {
        $this->criarMarcaDosTestes();
        $dados = [
            'marca_id' => $this->marca->id,
            'litragem' => 3.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 7.5,
        ];
        $refrigerante = factory(Refrigerante::class)->create($dados);

        $response = $this->get("/api/refrigerantes/{$refrigerante->id}", [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment($dados);
    }

    public function testExcluirRefrigeranteDoEstoque()
    {
        $this->criarMarcaDosTestes();
        $dados = [
            'marca_id' => $this->marca->id,
            'litragem' => 3.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 7.5,
        ];
        $refrigerante = factory(Refrigerante::class)->create($dados);

        $response = $this->delete("/api/refrigerantes/{$refrigerante->id}", [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(204);
    }

    public function metodosHttpDeAtualizar()
    {
        return [
            [ 'patch' ],
            [ 'put' ],
        ];
    }

    public function dadosInvalidos()
    {
        return [
            // Campos obrigatórios
            [
                [
                    'litragem' => 2.5,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 2.5,
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 2.5,
                    'tipo' => 'Pet',
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 2.5,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                ]
            ],
            // Marca
            [
                [
                    'marca_id' => -1,
                    'litragem' => 2.5,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            // Litragem
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => -0.1,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 5.1,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 3.5,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            // Tipo
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 3,
                    'tipo' => 'Garrafão',
                    'quantidade' => 30,
                    'valor_unitario' => 7.5,
                ]
            ],
            // Quantidade
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 3,
                    'tipo' => 'Pet',
                    'quantidade' => -1,
                    'valor_unitario' => 7.5,
                ]
            ],
            // Valor unitário
            [
                [
                    'marca_id' => $this->marca->id,
                    'litragem' => 3,
                    'tipo' => 'Pet',
                    'quantidade' => 30,
                    'valor_unitario' => -0.1,
                ]
            ],
        ];
    }
}
