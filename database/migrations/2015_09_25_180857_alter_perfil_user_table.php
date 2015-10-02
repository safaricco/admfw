<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPerfilUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perfil_user', function(Blueprint $table){
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_perfil')->references('id_perfil')->on('perfil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perfil_user', function ($table) {
            $table->dropForeign('perfil_user_id_user_foreign');
            $table->dropForeign('perfil_user_id_perfil_foreign');
        });
    }
}
