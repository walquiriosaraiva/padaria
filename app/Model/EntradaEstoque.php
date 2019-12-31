<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntradaEstoque extends Model
{
    protected $table = 'entrada_estoque';

    protected $fillable = [
        'num_nota_fiscal',
        'quantidade',
        'val_unitario',
        'produto_id',
        'unidade_medida_id'
    ];

}
