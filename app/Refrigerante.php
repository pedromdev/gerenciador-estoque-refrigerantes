<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Refrigerante extends Model
{
    protected $collection = 'refrigerantes';

    protected $fillable = [
        'marca',
        'tipo',
        'sabor',
        'litragem',
        'valor_unitario',
        'quantidade'
    ];

    protected $attributes = [
        'litragem' => 0,
        'valor_unitario' => 0.0,
        'quatidade' => 0
    ];
}
