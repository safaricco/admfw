<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicos', function(Blueprint $table){
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
        Schema::table('servicos', function ($table) {
            $table->dropForeign('servicos_id_subcategoria_foreign');
        });
    }
}
