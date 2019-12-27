<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'banco';

    protected $fillable = [
        'nome'
    ];

}
