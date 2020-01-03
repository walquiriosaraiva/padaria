<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaidaEstoque extends Model
{
    protected $table = 'saida_estoque';

    protected $fillable = [
        'num_cupom',
        'quantidade',
        'val_unitario',
        'produto_id',
        'unidade_medida_id',
        'user_id'
    ];

}
