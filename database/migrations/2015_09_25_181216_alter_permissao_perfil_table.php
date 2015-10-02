<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPermissaoPerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissao_perfil', function(Blueprint $table){
            $table->foreign('id_funcao')->references('id_funcao')->on('funcao');
            $table->foreign('id_perfil')->references('id_perfil')->on('perfil');
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
        Schema::table('permissao_perfil', function ($table) {
            $table->dropForeign('permissao_perfil_id_funcao_foreign');
            $table->dropForeign('permissao_perfil_id_perfil_foreign');
            $table->dropForeign('permissao_perfil_id_role_foreign');
        });
    }
}
