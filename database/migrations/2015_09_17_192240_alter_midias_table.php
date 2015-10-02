<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMidiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('midia', function(Blueprint $table){
            $table->foreign('id_tipo_midia')->references('id_tipo_midia')->on('tipo_midia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('midia', function ($table) {
            $table->dropForeign('midia_id_tipo_midia_foreign');
        });
    }
}
