<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTable extends Migration
{
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao',200);
            $table->integer('qtd_minimo');
            $table->unsignedInteger('unidade_medida_id');
            $table->decimal('val_unitario',8,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto');
    }
}
