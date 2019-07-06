<?php

namespace App;

use App\Exceptions\MarcaRegistradaException;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Marca extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $table = 'marcas';

    protected $fillable = [
        'nome',
        'slug'
    ];

    protected $cascadeDeletes = [
        'refrigerantes'
    ];

    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
        'deleted_at'
    ];

    /**
     * Método de relacionamento com o model de usuários
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Método de relacionamento com o model de refrigerantes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refrigerantes()
    {
        return $this->hasMany(Refrigerante::class);
    }

    /**
     * @param string $nome
     * @param User $user
     * @return Marca
     * @throws MarcaRegistradaException
     */
    public static function adicionar($nome, User $user)
    {
        $slug = Str::slug($nome);
        $marca = self::where('user_id', $user->id)
            ->where('slug', $slug)
            ->first();

        if (isset($marca->id)) {
            throw new MarcaRegistradaException("A marca $nome já está registrada a este usuário");
        }

        $marca = new Marca([
            'nome' => $nome,
            'slug' => $slug,
            'user_id' => $user->id,
        ]);
        $user->marcas()->save($marca);
        return $marca;
    }
}
