<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPermissaoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissao_user', function(Blueprint $table){
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_funcao')->references('id_funcao')->on('funcao');
            $table->foreign('id_role')->references('id_role')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissao_user', function ($table) {
            $table->dropForeign('permissao_user_id_user_foreign');
            $table->dropForeign('permissao_user_id_funcao_foreign');
            $table->dropForeign('permissao_user_id_role_foreign');
        });
    }
}
