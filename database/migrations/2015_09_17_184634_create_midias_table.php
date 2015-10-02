<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMidiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midia', function (Blueprint $table) {
            $table->increments('id_midia');
            $table->integer('id_tipo_midia')->unsigned();
            $table->integer('id_registro_tabela')->unsigned();
            $table->string('descricao')->nullable();
            $table->string('imagem_destacada')->nullable();
            $table->integer('ordem')->nullable();
            $table->integer('status')->default(1);
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
        Schema::drop('midia');
    }
}
