<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id_comentario');
            $table->integer('id_comentario_pai')->nullable();
            $table->integer('id_noticia')->unsigned();
            $table->integer('id_status_comentario')->unsigned();
            $table->string('nome');
            $table->string('email');
            $table->longText('texto');
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
        Schema::drop('comentarios');
    }
}
