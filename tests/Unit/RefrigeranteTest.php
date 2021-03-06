<?php

namespace Tests\Unit;

use App\Marca;
use App\Refrigerante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefrigeranteTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistraRefrigerante()
    {
        factory(Refrigerante::class)->create([
            'litragem' => 1.5,
            'tipo' => 'Pet',
            'quantidade' => 30,
            'valor_unitario' => 8.5,
        ]);

        $this->assertDatabaseHas('refrigerantes', [
            'tipo' => 'Pet'
        ]);
    }

    /**
     * @expectedException \PDOException
     * @expectedExceptionCode 23000
     */
    public function testNaoRegistraRefrigeranteDeMesmaMarcaELitragem()
    {
        $marca = factory(Marca::class)->make();

        factory(Refrigerante::class, 2)->create([
            'marca_id' => $marca->id,
            'litragem' => 1.5
        ]);
    }

    /**
     * @param float $litragem
     * @param string $tipo
     * @param int $quantidade
     * @param float $valorUnitario
     *
     * @expectedException \PDOException
     * @dataProvider valoresInvalidos
     */
    public function testNaoRegistraRefrigeranteComInformacoesIncorretas($litragem, $tipo, $quantidade, $valorUnitario)
    {
        factory(Refrigerante::class)->create([
            'litragem' => $litragem,
            'tipo' => $tipo,
            'quantidade' => $quantidade,
            'valor_unitario' => $valorUnitario,
        ]);
    }

    public function testAdicionaUmRefrigeranteNoEstoque()
    {
        $marca = factory(Marca::class)->create();
        $dados = [
            'litragem' => 2.5,
            'tipo' => 'Garrafa',
            'quantidade' => 30,
            'valor_unitario' => 6.5
        ];

        $refrigerante = Refrigerante::adicionar($dados, $marca);

        $this->assertDatabaseHas('refrigerantes', [
            'marca_id' => $marca->id,
            'litragem' => $dados['litragem']
        ]);
        $this->assertEquals($dados['litragem'], $refrigerante->litragem);
        $this->assertEquals($dados['tipo'], $refrigerante->tipo);
        $this->assertEquals($dados['quantidade'], $refrigerante->quantidade);
        $this->assertEquals($dados['valor_unitario'], $refrigerante->valor_unitario);
        $this->assertEquals($marca->id, $refrigerante->marca->id);
    }

    /**
     * @expectedException \App\Exceptions\RefrigeranteRegistradoException
     */
    public function testNaoAdicionaUmRefrigeranteNoEstoqueQuandoJaExisteUmComMesmaMarcaELitragem()
    {
        $dados = [
            'litragem' => 2.5,
            'tipo' => 'Garrafa',
            'quantidade' => 30,
            'valor_unitario' => 6.5
        ];
        $refrigerante = factory(Refrigerante::class)->create($dados);

        Refrigerante::adicionar($dados, $refrigerante->marca);
    }

    public function valoresInvalidos()
    {
        return [
            [-1, 'Pet', 1, 1],
            [1, 'Copo', 1, 1],
            [1, 'Pet', -1, 1],
            [1, 'Pet', 1, -1],
        ];
    }
}
