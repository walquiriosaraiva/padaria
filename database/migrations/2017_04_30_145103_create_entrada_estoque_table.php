<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaEstoqueTable extends Migration
{
    public function up()
    {
        Schema::create('entrada_estoque', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_nota_fiscal',100);
            $table->integer('quantidade');
            $table->decimal('val_unitario',8,2);
            $table->unsignedInteger('produto_id');
            $table->unsignedInteger('unidade_medida_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entrada_estoque');
    }
}
