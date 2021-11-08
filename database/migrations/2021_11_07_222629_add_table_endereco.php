<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('contato_id');
            $table->unsignedinteger('logradouro_id');
            $table->integer('numero');

            $table->foreign('logradouro_id')->references('id')->on('logradouro');
            $table->foreign('contato_id')->references('id')->on('contatos');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endereco');
    }
}
