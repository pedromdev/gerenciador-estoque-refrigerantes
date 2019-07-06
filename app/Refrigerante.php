<?php

namespace App;

use App\Exceptions\RefrigeranteRegistradoException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refrigerante extends Model
{

    use SoftDeletes;

    protected $table = 'refrigerantes';

    protected $fillable = [
        'litragem',
        'tipo',
        'quantidade',
        'valor_unitario',
    ];

    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
        'deleted_at'
    ];

    /**
     * Método de relacionamento com o model Marca
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    /**
     * Adiciona um novo refrigerante
     *
     * @param array $dados
     * @param Marca $marca
     * @return mixed
     * @throws RefrigeranteRegistradoException Se já houver um refrigerante registrado com a mesma marca e litragem
     */
    public static function adicionar(array $dados, Marca $marca)
    {
        $refrigerante = self::where('marca_id', $marca->id)
            ->where('litragem', $dados['litragem'])
            ->first();
        $litragem = $dados['litragem'] >= 1 ? "${dados['litragem']} L" : $dados['litragem'] * 1000 . " mL";

        if (isset($refrigerante->id)) {
            throw new RefrigeranteRegistradoException(
                "Um refrigerante {$marca->id} de ${litragem} já foi registrado"
            );
        }

        $refrigerante = new Refrigerante(array_merge($dados, [ 'marca_id' => $marca->id ]));
        $marca->refrigerantes()->save($refrigerante);
        return $refrigerante;
    }
}
