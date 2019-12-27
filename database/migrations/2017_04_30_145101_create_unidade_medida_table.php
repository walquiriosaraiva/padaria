<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeMedidaTable extends Migration
{
    public function up()
    {
        Schema::create('unidade_medida', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla',100);
            $table->string('descricao',200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidade_medida');
    }
}
