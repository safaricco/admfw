<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias',function(Blueprint $table){
            $table->increments('id_noticia');
            $table->integer('id_subcategoria')->unsigned();
            $table->string('titulo',255);
            $table->text('texto');
            $table->date('data');
            $table->string('destaque')->nullable();
            $table->integer('status')->default(1);
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
        Schema::drop('noticias');
    }

}
