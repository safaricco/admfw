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
            $table->string('operacao')->nullable();
            $table->string('status_request')->nullable();
            $table->string('site')->nullable();
            $table->string('dominio')->nullable();
            $table->string('sistema_operacional')->nullable();
            $table->string('navegador')->nullable();
            $table->string('ipUsuario')->nullable();
            $table->string('ipServidor')->nullable();
            $table->string('usuario')->nullable();
            $table->string('urlOrigem')->nullable();
            $table->string('urlDestino')->nullable();
            $table->string('method')->nullable();
            $table->longText('dados')->nullable();
            $table->string('tipo_servidor')->nullable();
            $table->string('ambiente')->nullable();
            $table->string('debug')->nullable();
            $table->string('banco')->nullable();
            $table->string('mail_server')->nullable();
            $table->string('document_root')->nullable();
            $table->string('resolucao_tela')->nullable();
            $table->string('mensagem')->nullable();
            $table->string('arquivo')->nullable();
            $table->string('codigo_erro')->nullable();
            $table->string('linha')->nullable();
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
