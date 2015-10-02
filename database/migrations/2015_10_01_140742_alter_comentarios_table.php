<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comentarios', function(Blueprint $table){
            $table->foreign('id_noticia')->references('id_noticia')->on('noticias');
            $table->foreign('id_status_comentario')->references('id_status_comentario')->on('status_comentario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentarios', function ($table) {
            $table->dropForeign('comentarios_id_noticia_foreign');
            $table->dropForeign('comentarios_id_status_comentario_foreign');
        });
    }
}
