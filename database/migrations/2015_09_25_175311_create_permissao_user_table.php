<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_user', function (Blueprint $table) {
            $table->increments('id_permissao_user');
            $table->integer('id_funcao')->unsigned();
            $table->integer('id_user')->unsigned();
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
        Schema::drop('permissao_user');
    }
}
