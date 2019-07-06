<?php

namespace App;

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

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
