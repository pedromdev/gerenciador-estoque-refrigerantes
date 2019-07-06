<?php

namespace Tests\Unit;

use App\Marca;
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

    public function valoresInvalidos()
    {
        return [
            [Str::random(31), 'marca'],
            ['Marca', Str::random(31)],
        ];
    }
}
