<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMultimidiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multimidia', function(Blueprint $table){
            $table->foreign('id_midia')->references('id_midia')->on('midia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multimidia', function ($table) {
            $table->dropForeign('multimidia_id_midia_foreign');
        });
    }
}
