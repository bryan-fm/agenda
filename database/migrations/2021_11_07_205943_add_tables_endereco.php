<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablesEndereco extends Migration
{

    public function up()
    {
        Schema::create('uf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla');
            $table->string('nome');
        });

        DB::table('uf')->insert(['sigla' => 'AC', 'nome' => 'ACRE']);
        DB::table('uf')->insert(['sigla' => 'AL', 'nome' => 'ALAGOAS']);
        DB::table('uf')->insert(['sigla' => 'AM', 'nome' => 'AMAZONAS']);
        DB::table('uf')->insert(['sigla' => 'AP', 'nome' => 'AMAPÁ']);
        DB::table('uf')->insert(['sigla' => 'BA', 'nome' => 'BAHIA']);
        DB::table('uf')->insert(['sigla' => 'CE', 'nome' => 'CEARÁ']);
        DB::table('uf')->insert(['sigla' => 'DF', 'nome' => 'DISTRITO FEDERAL']);
        DB::table('uf')->insert(['sigla' => 'ES', 'nome' => 'ESPÍRITO SANTO']);
        DB::table('uf')->insert(['sigla' => 'GO', 'nome' => 'GOIÁS']);
        DB::table('uf')->insert(['sigla' => 'MA', 'nome' => 'MARANHÃO']);
        DB::table('uf')->insert(['sigla' => 'MG', 'nome' => 'MINAS GERAIS']);
        DB::table('uf')->insert(['sigla' => 'MS', 'nome' => 'MATO GROSSO DO SUL']);
        DB::table('uf')->insert(['sigla' => 'MT', 'nome' => 'MATO GROSSO']);
        DB::table('uf')->insert(['sigla' => 'PA', 'nome' => 'PARÁ']);
        DB::table('uf')->insert(['sigla' => 'PB', 'nome' => 'PARAIBA']);
        DB::table('uf')->insert(['sigla' => 'PE', 'nome' => 'PERNAMBUCO']);
        DB::table('uf')->insert(['sigla' => 'PI', 'nome' => 'PIAUÍ']);
        DB::table('uf')->insert(['sigla' => 'PR', 'nome' => 'PARANÁ']);
        DB::table('uf')->insert(['sigla' => 'RJ', 'nome' => 'RIO DE JANEIRO']);
        DB::table('uf')->insert(['sigla' => 'RN', 'nome' => 'RIO GRANDE DO NORTE']);
        DB::table('uf')->insert(['sigla' => 'RO', 'nome' => 'RONDÔNIA']);
        DB::table('uf')->insert(['sigla' => 'RR', 'nome' => 'RORAIMA']);
        DB::table('uf')->insert(['sigla' => 'RS', 'nome' => 'RIO GRANDE DO SUL']);
        DB::table('uf')->insert(['sigla' => 'SC', 'nome' => 'SANTA CATARINA']);
        DB::table('uf')->insert(['sigla' => 'SE', 'nome' => 'SERGIPE']);
        DB::table('uf')->insert(['sigla' => 'SP', 'nome' => 'SÃO PAULO']);
        DB::table('uf')->insert(['sigla' => 'TO', 'nome' => 'TOCANTINS']);
        


        Schema::create('cidade', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedinteger('uf_id');

            $table->foreign('uf_id')->references('id')->on('uf');

        });

        Schema::create('bairro', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedinteger('cidade_id');

            $table->foreign('cidade_id')->references('id')->on('cidade');
        });

        Schema::create('logradouro', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cep');
            $table->unsignedinteger('bairro_id');

            $table->foreign('bairro_id')->references('id')->on('bairro');
        });
    }


    public function down()
    {
        Schema::dropIfExists('logradouro');
        Schema::dropIfExists('bairro');
        Schema::dropIfExists('cidade');
        Schema::dropIfExists('uf');
    }
}
