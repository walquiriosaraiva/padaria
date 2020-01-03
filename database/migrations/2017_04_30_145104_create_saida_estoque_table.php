<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidaEstoqueTable extends Migration
{
    public function up()
    {
        Schema::create('saida_estoque', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_cupom',100);
            $table->integer('quantidade');
            $table->decimal('val_unitario',8,2);
            $table->unsignedInteger('produto_id');
            $table->unsignedInteger('unidade_medida_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saida_estoque');
    }
}
