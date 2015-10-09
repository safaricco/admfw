<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('id_log');
            $table->string('tipo');
            $table->string('site')->nullable();
            $table->string('dominio')->nullable();
            $table->string('sistema_operacional')->nullable();
            $table->string('navegador')->nullable();
            $table->string('ip')->nullable();
            $table->string('usuario')->nullable();
            $table->string('url')->nullable();
            $table->string('resolucao_tela')->nullable();
            $table->string('mensagem')->nullable();
            $table->string('arquivo')->nullable();
            $table->string('codigo_erro')->nullable();
            $table->longText('trace_string')->nullable();
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
        Schema::drop('log');
    }
}
