<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancoTable extends Migration
{
    public function up()
    {
        Schema::create('banco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banco');
    }
}
