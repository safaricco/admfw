<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoPerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_perfil', function (Blueprint $table) {
            $table->increments('id_permissao_perfil');
            $table->integer('id_funcao')->unsigned();
            $table->integer('id_perfil')->unsigned();
            $table->integer('id_role')->unsigned();
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
        Schema::drop('permissao_perfil');
    }
}
