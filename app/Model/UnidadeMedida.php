<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    protected $table = 'unidade_medida';

    protected $fillable = [
        'sigla', 'descricao'
    ];

}
