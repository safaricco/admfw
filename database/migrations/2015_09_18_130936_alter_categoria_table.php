<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorias', function(Blueprint $table){
            $table->foreign('id_tipo_categoria')->references('id_tipo_categoria')->on('tipo_categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorias', function ($table) {
            $table->dropForeign('categorias_id_tipo_categoria_foreign');
        });
    }
}
