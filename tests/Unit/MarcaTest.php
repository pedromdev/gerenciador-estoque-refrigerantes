<?php

namespace Tests\Unit;

use App\Marca;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MarcaTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrarMarcaDeRefrigerante()
    {
        $nome = 'Marca';
        $slug = 'marca';

        $marca = factory(Marca::class)->create([
            'nome' => $nome,
            'slug' => $slug,
        ]);

        $this->assertDatabaseHas('marcas', [
            'nome' => $nome,
            'slug' => $slug
        ]);
        $this->assertEquals($nome, $marca->nome);
        $this->assertEquals($slug, $marca->slug);
    }

    /**
     * @param string $nome
     * @param string $slug
     *
     * @expectedException \PDOException
     * @expectedExceptionCode 22001
     * @expectedExceptionMessageRegExp /('nome'|'slug')/
     * @dataProvider valoresInvalidos
     */
    public function testNaoRegistraMarcaDeRefrigeranteComNomeOuSlugMaiorQue30Caracteres($nome, $slug)
    {
        factory(Marca::class)->create([
            'nome' => $nome,
            'slug' => $slug,
        ]);
    }

    public function testAdicionaUmaMarca()
    {
        $user = factory(User::class)->create();
        $nome = 'Coca-Cola';

        $marca = Marca::adicionar($nome, $user);

        $this->assertDatabaseHas('marcas', [
            'slug' => 'coca-cola'
        ]);
        $this->assertEquals($nome, $marca->nome);
        $this->assertEquals(Str::slug($nome), $marca->slug);
        $this->assertEquals($user->id, $marca->user->id);
    }

    /**
     * @expectedException \App\Exceptions\MarcaRegistradaException
     */
    public function testNaoAdicionaUmaMarcaQuandoOUsuarioJaRegistrou()
    {
        $nome = 'Coca-Cola';
        $dados = [
            'nome' => $nome,
            'slug' => Str::slug($nome),
        ];
        $marca = factory(Marca::class)->create($dados);

        Marca::adicionar($nome, $marca->user);
    }

    public function valoresInvalidos()
    {
        return [
            [Str::random(31), 'marca'],
            ['Marca', Str::random(31)],
        ];
    }
}
