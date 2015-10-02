<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id_produto');
            $table->integer('id_subcategoria')->unsigned();
            $table->string('ref')->nullable();
            $table->string('nome');
            $table->longText('descricao');
            $table->string('imagem');
            $table->integer('status')->default(0);
            $table->timestamps();

            //$table->foreign('idSubcategoria')->references('id')->on('subcategorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('produtos');
    }
}
