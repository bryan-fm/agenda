<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableCategoria extends Migration
{

    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
        });

        DB::table('categoria')->insert(['id' => 1, 'descricao' => 'Outros']);
    }


    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
