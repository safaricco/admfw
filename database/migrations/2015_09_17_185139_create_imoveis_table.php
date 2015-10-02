<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImoveisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imoveis', function (Blueprint $table) {
            $table->increments('id_imovel');
            $table->string('contrato');
            $table->string('ref');
            $table->string('titulo');
            $table->longText('descricao')->nullable();
            $table->longText('obs')->nullable();
            $table->decimal('valor', 18,9);
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('numero')->nullable();
            $table->string('cep')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('dimensoes')->nullable();
            $table->string('area_terreno')->nullable();
            $table->string('area_construida')->nullable();
            $table->string('area_privativa')->nullable();
            $table->string('area_util')->nullable();
            $table->string('andares')->nullable();
            $table->string('elevadores')->nullable();
            $table->string('quartos')->nullable();
            $table->string('suites')->nullable();
            $table->string('garagem')->nullable();
            $table->string('banheiros')->nullable();
            $table->string('detalhes')->nullable();
            $table->string('valor_iptu')->nullable();
            $table->string('sala_jantar')->default('nao');
            $table->string('sala_estar')->default('nao');
            $table->string('sala_tv')->default('nao');
            $table->string('cozinha')->default('nao');
            $table->string('area_de_servico')->default('nao');
            $table->string('dependencia_empregada')->default('nao');
            $table->string('gas_central')->default('nao');
            $table->string('playground')->default('nao');
            $table->string('lavabo')->default('nao');
            $table->string('churrasqueira')->default('nao');
            $table->string('salao_festas')->default('nao');
            $table->string('sacada')->default('nao');
            $table->string('portao_eletronico')->default('nao');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('imoveis');
    }
}
