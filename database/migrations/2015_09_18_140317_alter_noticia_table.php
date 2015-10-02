<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNoticiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noticias', function(Blueprint $table){
            $table->foreign('id_subcategoria')->references('id_subcategoria')->on('subcategorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('noticias', function ($table) {
            $table->dropForeign('noticias_id_subcategoria_foreign');
        });
    }
}
