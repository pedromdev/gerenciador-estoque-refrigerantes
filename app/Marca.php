<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refrigerantes()
    {
        return $this->hasMany(Refrigerante::class);
    }
}
